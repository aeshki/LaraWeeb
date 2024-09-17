<script setup>
import { ref } from 'vue';
import { UserAvatar } from '@/components/user';
import { Trash2, Pen } from 'lucide-vue-next';
import useAxios from '@/utils/useAxios';
import { useModal } from '@/utils/modal';
import DialogModal from '@/components/common/modals/DialogModal.vue';

const modal = useModal();

const props = defineProps({
    id: [Number, String],
    pseudo: String,
    username: {
        type: String,
        required: true
    },
    message: {
        type: String,
        required: true
    },
    avatar: String,
    canEdit: Boolean,
    canDelete: Boolean
});

const emit = defineEmits([ 'deleted' ]);

const message = ref(props.message);

const handleEdit = () => {
    modal.open({
        component: DialogModal,
        props: {
            title: 'Modifier un commentaire',
            inputs: [
                {
                    id: 'message',
                    type: 'area',
                    label: 'Message',
                    model: message
                }
            ]
        },
        onSubmit: async (data) => {
            const { onResolve } = useAxios(`/api/comments/${props.id}`, {
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

const handleDelete = () => {
    const { onResolve } = useAxios(`/api/comments/${props.id}`, { method: 'DELETE' });

    onResolve(() => {
        emit('deleted', props.id);
    });
}
</script>

<template>
    <div class='flex gap-2 border bg-neutral-800 border-neutral-600 p-2 rounded-lg overflow-hidden sm:max-w-screen-sm sm:w-full'>
        <UserAvatar :username='username' :path='avatar' />
        <div class='flex flex-col w-full'>
            <div class='flex justify-between w-full'>
                <span>{{ pseudo ?? username }}</span>
                <div
                    v-if='canEdit || canDelete'    
                    class='flex gap-2 *:text-neutral-400 hover:*:text-neutral-300 *:transition-all *:duration-100'
                >
                    <Pen
                        v-if='canEdit'
                        size='18'
                        @click='handleEdit'
                    />

                    <Trash2
                        v-if='canDelete'
                        size='18'
                        @click='handleDelete'
                    />
                </div>
            </div>
            <p class=''>{{ message }}</p>
        </div>
    </div>
</template>