<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

import UserAvatar from '@/components/User/Avatar.vue';
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import AreaInput from '@/components/inputs/AreaInput.vue';
import RoundedButton from '@/components/inputs/RoundedButton.vue';

import {
    Trash2,
    Pen
} from 'lucide-vue-next';
import axios from 'axios';

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

const haveModification = computed(() => message.value.toLowerCase().replaceAll(' ', '') !== props.message.toLowerCase().replaceAll(' ', ''));

const editing = ref(false);

const handleClick = () => {
    if (!isSameRoute && (window.getSelection().toString().length < 1) && !editing.value) {
        router.push(`/posts/${props.id}`);
    }
}

const handleDelete = () => {
    axios.delete(`/api/posts/${props.id}`)
        .then(() => emit('destroy', props.id));
}

const toggleEdit = () => {
    editing.value = !editing.value;
}

const handleSave = () => {
    if (!haveModification || message.length < 2) {
        return
    }

    axios.patch(`/api/posts/${props.id}`, { message: message.value });

    toggleEdit();
}
</script>

<template>
    <div class='flex items-start p-4 gap-3 transition-all duration-75 cursor-pointer'
         :class="isSameRoute ? '': 'hover:bg-zinc-950'"
         tabindex='0'
         @click='handleClick'
    >
        <UserAvatar :isLoading='isLoading'
                    :to='`/@${username}`'
                    @click.stop />

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

                    <div v-if='(canEdit || canDelete) && !editing'
                        class='flex gap-2 *:text-neutral-400 hover:*:text-neutral-300 *:transition-all *:duration-100'
                    >
                        <Pen v-if='canEdit'
                             size='18'
                             @click.stop='toggleEdit'
                             @keydown.enter='toggleEdit' />

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

            <AreaInput v-else-if='editing'
                v-model='message'
                required
            />

            <p v-else class='whitespace-pre-line'>{{ message }}</p>

            <div
                v-if='editing'
                class='flex justify-end gap-2 mt-2'
            >
                <RoundedButton
                    text='Cancel'
                    @click.stop='toggleEdit'
                    @keydown.enter='toggleEdit'
                />

                <RoundedButton
                    text='Save'
                    variant='fill'
                    :disabled='!haveModification || message.length < 2'
                    @click.stop='handleSave'
                    @keydown.enter='handleSave'
                />
            </div>
        </div>
    </div>
</template>