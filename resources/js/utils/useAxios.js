import { ref, watchEffect, toValue, watch } from 'vue';
import axios from 'axios';

export default function useAxios(url, config = []) {
    const data = ref(null);
    const errors = ref([]);
    const loading = ref(false);
    
    const isNotFound = ref(false);

    const fetchRequest = (newData) => {
        loading.value = true;
        errors.value = [];

        axios.request({ url: toValue(url), ...{ ...config, data: newData ?? config?.data } })
            .then((res) => data.value = res.data)
            .catch((err) => {
                errors.value = err.response.data.errors ? err.response.data.errors : err
                isNotFound.value = err.response.status === 404;
            })
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
        isNotFound,
        fetchRequest,
        onResolve,
        onFulfilled,
        onRejected
    };
}