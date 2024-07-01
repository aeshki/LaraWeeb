import { h, render, ref } from 'vue';

export const useModal = () => {
    const isOpen = ref(false);
    const errors = ref({});

    const modals = document.getElementById('modals');
    let vnode = null;

    const close = () => {
        render(null, modals);
        vnode = null;
        isOpen.value = false;
    }

    const open = ({ component, props, onSubmit }) => {
        vnode = h(component, {
            onClickOutside: () => close(),
            onCancel: () => close(),
            onSubmit,
            errors,
            ...props
        });

        render(vnode, modals);
        isOpen.value = true;
    }

    const setErrors = (err) => {
        errors.value = err;
    }

    return {
        isOpen,
        close,
        open,
        setErrors
    }
};