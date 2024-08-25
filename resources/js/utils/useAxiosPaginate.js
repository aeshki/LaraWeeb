import { ref, watchEffect, toValue, watch } from 'vue';
import axios from 'axios';

export default function useAxiosPaginate(url, config = []) {
    const loading = ref(false);
    const error = ref(null);

    const message = ref(null);
    const data = ref(null);
    const current_page = ref(0);
    const per_page = ref(0);
    const to = ref(0);

    watchEffect(() => {
        loading.value = true;
        
        axios.request({ url: toValue(url), ...config })
            .then((res) => {
                message.value = res.message;

                const props = Object.values(res.data)[1];
                current_page.value = props.current_page;
                per_page.value = props.per_page;
                data.value = props.data
                to.value = props.to;
            })
            .catch((err) => error.value = err)
            .finally(() => loading.value = false);
    });

    const onResolve = (callback) => {
        watch(loading, () => !loading.value && callback({ data, error }));
    }

    const onFulfilled  = (callback) => {
        watch(loading, () => (!loading.value && !error.value) && callback(data));
    }

    const onRejected = (callback) => {
        watch(loading, () => (!loading.value && error.value) && callback(error));
    }

    return {
        current_page,
        per_page,
        loading,
        message,
        error,
        data,
        to,
        onResolve,
        onFulfilled,
        onRejected
    };
}