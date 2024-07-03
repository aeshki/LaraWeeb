import { ref, watchEffect, toValue, watch, reactive } from 'vue';
import axios from 'axios';

export default function useAxios(url, config = []) {
    const data = ref(null);
    const error = ref(null);
    const loading = ref(false);

    watchEffect(() => {
        loading.value = true;
        
        axios.request({ url: toValue(url), ...config })
            .then((res) => data.value = res.data)
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
        data,
        error,
        loading,
        onResolve,
        onFulfilled,
        onRejected
    };
}