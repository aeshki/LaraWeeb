import { h, render, ref } from 'vue';

export const useModal = () => {
    const isOpen = ref(false);
    const errors = ref({});

    const modals = document.getElementById('modals');
    let vnode = null;

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

    const close = () => {
        render(null, modals);
        vnode = null;
        $reset();
    }

    const setErrors = (err) => {
        errors.value = err;
    }

    const $reset = () => {
        isOpen.value = false;
        errors.value = {};
    }

    return {
        isOpen,
        close,
        open,
        setErrors
    }
};