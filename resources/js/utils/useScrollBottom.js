import { ref, onMounted, onUnmounted } from 'vue';

export default function useScrollBottom(target) {
    const bottomReached = ref(false);

    const checkIfBottom = () => {
        if (!target.value) return;

        const {
            scrollTop,
            scrollHeight,
            clientHeight
        } = target.value;

        bottomReached.value = scrollTop + clientHeight >= scrollHeight;
    };

    onMounted(() => {
        if (target.value) {
            target.value.addEventListener('scroll', checkIfBottom);
        }
    });

    onUnmounted(() => {
        if (target.value) {
            target.value.removeEventListener('scroll', checkIfBottom);
        }
    });

    return { bottomReached };
}