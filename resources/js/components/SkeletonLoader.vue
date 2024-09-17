<script setup>
import colors from 'tailwindcss/colors';
import { computed, toRefs } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'rounded-lg',
    },
    bgColor: {
        type: String,
        default: 'bg-neutral-400',
    },
    shimmerColor: {
        type: String,
        default: 'slate-50',
    },
});

const { type, bgColor, shimmerColor } = toRefs(props);

const isHexColor = (hexColor) => {
    const hexCode = hexColor.replace('#', '');

    return typeof hexColor === 'string' && (hexCode.length === 3 || hexCode.length === 6) && !isNaN(+('0x' + hexCode));
};

const hexToRgb = (hex) => {
  const parts = hex.match(/([0-9]|[A-F]|[a-f])/g);

  if (parts.length !== 6 && parts.length !== 3) {
    throw Error('It is not a hexadecimal value. In hexadecimal must contain 3 or 6 characters from 0 to 9 and A to F.');
  }

  return parts.reduce((acc, current, index) => {
    if (parts.length === 3) {
      acc.push(parseInt(current + current, 16));
    } else if (index % 2 === 0) {
      acc.push(current);
    } else {
      acc[acc.length - 1] = parseInt(acc[acc.length - 1] + current, 16);
    }

    return acc;
  }, []);
}

const shimmerStyle = computed(() => {
  let RGB = '#FFFFFF';

  if (isHexColor(shimmerColor.value)) {
    RGB = hexToRgb(shimmerColor.value);
  } else {
    const parts = shimmerColor.value.split('-');
    RGB = hexToRgb(parts[1] ? colors[parts[0]][parts[1]] : colors[parts[0]]);
  }

  return {
    backgroundImage: `linear-gradient(90deg, rgba(${RGB}, 0) 0%, rgba(${RGB}, 0.2) 20%, rgba(${RGB}, 0.5) 60%, rgba(${RGB}, 0))`,
  };
});
</script>

<template>
  <div :class="[type === 'circle' ? 'rounded-full' : 'rounded', bgColor, 'relative overflow-hidden']">
    <div
      :style='shimmerStyle'
      class='animate-shimmer -translate-x-full absolute top-0 right-0 bottom-0 left-0'
    ></div>
  </div>
</template>