<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useModal } from '@/utils/modal.js';
import useAxios from '@/utils/useAxios';

const modal = useModal();
const router = useRouter();

import DialogModal from '@/components/common/modals/DialogModal.vue';
import { UserAvatar } from '@/components/user';
import SkeletonLoader from '@/components/SkeletonLoader.vue';
import { RoundedButton, AreaInput } from '@/components/common';
import CommentCard from '@/components/CommentCard.vue';

import { Trash2, Pen, Heart } from 'lucide-vue-next';

const props = defineProps({
    id: [String, Number],
    avatar: String,
    pseudo: String,
    username: String,
    lastestComment: Object,
    message: String,
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
    image: String,
    isLiked: {
        type: Boolean,
        default: false
    },
    likesCount: {
        type: Number,
        default: 0
    },
    canEdit: {
        type: Boolean,
        default: false
    },
    canDelete: {
        type: Boolean,
        default: false
    },
});

const emit = defineEmits([
    'like',
    'unlike',
    'destroy',
    'tagClicked'
]);

const message = ref(props.message);

const isLiked = ref(props.isLiked);
const likesCount = ref(props.likesCount);

const isSameRoute = router.currentRoute.value.path === `/posts/${props.id}`;

const handleClick = () => {
    if (!isSameRoute && (window.getSelection().toString().length < 1)) {
        router.push(`/posts/${props.id}`);
    }
}

const handleDelete = () => {
    const { onResolve } = useAxios(`/api/posts/${props.id}`, { method: 'DELETE' });

    onResolve(() => {
        emit('destroy', props.id);
    });
}

const toggleLike = () => {
    if (isLiked.value) {
        const { onFulfilled } = useAxios(`/api/posts/${props.id}/like`, { method: 'DELETE' });

        onFulfilled(() => {
            likesCount.value--;
            isLiked.value = false;
            emit('unlike');
        });
    } else {
        const { onFulfilled } = useAxios(`/api/posts/${props.id}/like`, { method: 'POST' });
    
        onFulfilled(() => {
            likesCount.value++;
            isLiked.value = true;
            emit('like');
        });
    }
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
            const { onResolve } = useAxios(`/api/posts/${props.id}`, {
                method: 'PATCH',
                data: { message: data.message }
            });

            onResolve(({ error }) => {
                if (error.value) {
                    modal.setErrors({ global: error.message });
                } else {
                    message.value = data.message;
                    modal.close();
                }
            });
        }
    });
}

const getBaseURL = () => {
    return window.location.origin;
}

const handleTagClicked = (tag) => {
    emit('tagClicked', tag);
}

function parseMessage(message) {
    const tagRegex = /#(\w+)/g;
    const parts = [];
    let lastIndex = 0;
    let match;

    while ((match = tagRegex.exec(message)) !== null) {
        if (match.index > lastIndex) {
            parts.push({
                value: message.slice(lastIndex, match.index),
                isTag: false
            });
        }

        parts.push({
            value: match[0],
            isTag: true
        });
        lastIndex = tagRegex.lastIndex;
    }

    if (lastIndex < message?.length) {
        parts.push({
            value: message.slice(lastIndex),
            isTag: false
        });
    }

    return parts;
}
</script>

<template>
    <div
        class='max-w-full w-full flex items-start p-4 gap-3 bg-zinc-800 rounded-xl border border-neutral-600 transition-all duration-75 cursor-pointer sm:max-w-screen-sm sm:w-full'
        :class="isSameRoute ? '': 'hover:bg-zinc-950'"
        tabindex='0'
        @click='handleClick'
    >
        <UserAvatar
            v-if='withAvatar'
            :username='username'
            :path='avatar'
            :isLoading='isLoading'
            :to='`/@${username}`'
            @click.stop
        />
        <div class='flex flex-col gap-2 text-white w-full overflow-hidden' >
            <div class='flex w-full justify-between'>
                <SkeletonLoader v-if='isLoading' class='w-36 h-3' />

                <template v-else>
                    <div class='flex flex-col'>
                        <div v-if='displayUserInfo' class='flex items-center gap-1'>
                            <div class='flex gap-1 items-center'>
                                <RouterLink class='text-white'
                                            :to='`/@${username}`'
                                            @click.stop
                                >{{ pseudo ?? username }}</RouterLink>
                            </div>

                            <span class='text-xs text-neutral-400'>
                            {{
                                new Date(createdAt).toLocaleDateString('default', {
                                    month: 'long',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric'
                                })
                            }}
                        </span>
                        </div>
                        <span
                                class='text-xs text-neutral-400'
                            >@{{ username }}</span>
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

            <div v-else class='bg-zinc-700 border border-neutral-500 p-2 rounded-lg'>
                <template v-if='message'>
                    <template
                        v-for='(part, idx) in parseMessage(message)'
                        :key='idx'
                    >
                        <RouterLink
                            class='text-indigo-300 whitespace-pre-wrap'
                            @click.stop='handleTagClicked(part.value)'
                            v-if='part.isTag'
                            :to='`/search?tag=${part.value.replace("#", "")}`'
                        >{{ part.value }}</RouterLink>
                        <p v-else class='break-words'>{{ part.value }}</p>
                    </template>
                </template>
                <img
                    v-if='image'
                    class='max-h-80 mt-1 w-fit rounded-xl border border-zinc-500'
                    :src='`${getBaseURL()}/storage/posts/${image}`'
                    alt='image'
                />
            </div>
            <div v-if='!isLoading' class='flex *:h-fit'>
                <div class='flex gap-1 justify-center font-bold' @click.stop='toggleLike() '>
                    <Heart
                        v-if='isLiked'
                        fill='#ff3d3d'
                        stroke='#ff3d3d'
                    />
                    <Heart
                        v-else
                        strokeWidth='1.5'
                        stroke='#ff3d3d'
                    />
                    <span v-if='likesCount'>{{ likesCount }}</span>
                </div>
            </div>
            <div
                v-if='lastestComment && lastestComment.author?.username !== username'
                class='bg-zinc-900 border border-neutral-600 p-2 rounded-lg'
            >
                <p class='mb-1'>Dernier commentaire</p>
                <CommentCard
                    :message='lastestComment.message'
                    :pseudo='lastestComment.author?.pseudo'
                    :username='lastestComment.author?.username'
                    :avatar='lastestComment.author?.avatar'
                />
            </div>
        </div>
    </div>
</template>