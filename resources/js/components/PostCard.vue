<script setup>
import { ref, computed, reactive, h } from 'vue';
import { useRouter } from 'vue-router';
import { useModal } from '@/stores/modal.js';

const modal = useModal();

const router = useRouter()

import DialogModal from '@/components/common/modals/DialogModal.vue';
import { UserAvatar } from '@/components/user';
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import { RoundedButton, AreaInput } from '@/components/common';

import {
    Trash2,
    Pen
} from 'lucide-vue-next';
import axios from 'axios';
import { MoonStar } from 'lucide-vue-next';

const props = defineProps({
    id: [String, Number],
    pseudo: String,
    username: String,
    message: {
        type: String,
        required: true
    },
    createdAt: String,
    displayUserInfo: {
        type: Boolean,
        default: true
    },
    isLoading: {
        type: Boolean,
        default: false
    },
    withAvatar: {
        type: Boolean,
        default: true
    },
    canEdit: {
        type: Boolean,
        default: false
    },
    canDelete: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits([ 'destroy' ]);

const message = ref(props.message);

const isSameRoute = router.currentRoute.value.path === `/posts/${props.id}`;

// const haveModification = computed(() => message.value.toLowerCase().replaceAll(' ', '') !== props.message.toLowerCase().replaceAll(' ', ''));

const handleClick = () => {
    if (!isSameRoute && (window.getSelection().toString().length < 1)) {
        router.push(`/posts/${props.id}`);
    }
}

const handleDelete = () => {
    axios.delete(`/api/posts/${props.id}`)
        .then(() => emit('destroy', props.id));
}

const showModal = () => {
    modal.open({
        component: DialogModal,
        props: {
            title: 'Modifier un poste',
            inputs: [
                {
                    id: 'message',
                    type: 'area',
                    label: 'Message du poste',
                    model: message
                }
            ]
        },
        onSubmit: async (data) => {
            modal.setErrors([ 'test' ]);

            await axios.patch(`/api/posts/${props.id}`, {
                message: data.message
            }).then(() => {
                message.value = data.message;
                modal.close();
            }).catch((err) => modal.setErrors({
                global: err.message
            }));
        }
    });
}
</script>

<template>
    <div
        class='flex items-start p-4 gap-3 bg-zinc-800 rounded-xl border border-neutral-600 transition-all duration-75 cursor-pointer sm:max-w-screen-sm sm:w-full'
        :class="isSameRoute ? '': 'hover:bg-zinc-950'"
        tabindex='0'
        @click='handleClick'
    >
        <UserAvatar
            v-if='withAvatar'
            :isLoading='isLoading'
            :to='`/@${username}`'
            @click.stop
        />
        <div class='flex flex-col gap-1 text-white w-full' >
            <div class='flex w-full justify-between'>
                <SkeletonLoader v-if='isLoading' class='w-36 h-3' />

                <template v-else>
                    <div class='flex gap-1 items-center'>
                        <template v-if='displayUserInfo'>
                            <div class='flex gap-1 items-center'>
                                <RouterLink class='text-white'
                                            :to='`/@${username}`'
                                            @click.stop
                                >{{ pseudo ?? username }}</RouterLink>
                            </div>

                            <span
                                class='text-xs text-neutral-400'
                            >@{{ username }} · </span>
                        </template>

                        <span class='text-xs text-neutral-400'>
                            {{
                                new Date(createdAt).toLocaleDateString('default', {
                                    month: 'long',
                                    day: 'numeric',
                                })
                            }}
                        </span>
                    </div>

                    <div v-if='(canEdit || canDelete)'
                        class='flex gap-2 *:text-neutral-400 hover:*:text-neutral-300 *:transition-all *:duration-100'
                    >
                        <Pen v-if='canEdit'
                             size='18'
                             @click.stop='showModal'
                             @keydown.enter='showModal' />

                        <Trash2 v-if='canDelete'
                                size='18'
                                @click.stop='handleDelete'
                                @keydown.enter='handleDelete' />
                    </div>
                </template>
            </div>

            <template v-if='isLoading'>
                <SkeletonLoader class='w-48 h-4 mt-2' />
                <SkeletonLoader class='w-44 h-4' />
                <SkeletonLoader class='w-52 h-4' />
            </template>

            <p v-else class='whitespace-pre-line'>{{ message }}</p>
        </div>
    </div>
</template>