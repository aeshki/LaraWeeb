import { ref, watchEffect, toValue, watch } from 'vue';
import axios from 'axios';

export default function useAxios(url, config = []) {
    const data = ref(null);
    const errors = ref([]);
    const loading = ref(false);

    const fetchRequest = () => {
        loading.value = true;
        errors.value = [];

        axios.request({ url: toValue(url), ...config })
            .then((res) => data.value = res.data)
            .catch((err) => errors.value = err.response.data.errors ? err.response.data.errors : err)
            .finally(() => loading.value = false);
    }

    const onResolve = (callback) => {
        watch(loading, () => !loading.value && callback({ data, errors }));
    }

    const onFulfilled  = (callback) => {
        watch(loading, () => (!loading.value && errors.value.length < 1) && callback(data));
    }

    const onRejected = (callback) => {
        watch(loading, () => (!loading.value && errors.value.length > 1) && callback(error));
    }

    if (!config.deferred) {
        watchEffect(() => fetchRequest());
    }

    return {
        data,
        errors,
        loading,
        fetchRequest,
        onResolve,
        onFulfilled,
        onRejected
    };
}