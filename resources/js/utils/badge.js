import { HandHeart } from 'lucide-vue-next';

import {
    DeveloperIcon,
    StaffIcon,
    NewMemberIcon
} from '@/components/icons';

export const BADGE_FLAGS = {
    STAFF: 1 << 0,
    DEVELOPER: 1 << 1,
    STAR: 1 << 2
};

export const BADGE_ICONS = {
    STAFF: StaffIcon,
    DEVELOPER: DeveloperIcon,
    STAR: NewMemberIcon
};

export const BADGE_LABELS = {
    STAFF: 'Staff LaraWeeb',
    DEVELOPER:'Développeur LaraWeeb',
    STAR: 'Une Star !'
};

export const bitwiseToBadgeKeys = (bitwise) => {
    return Object.entries(BADGE_FLAGS)
        .filter(([ _, flag ]) => (bitwise & flag) === flag)
        .map(([ key ]) => key);
}

export const bitwiseToBadgeIcons = (bitwise) => {
    return bitwiseToBadgeKeys(bitwise).map((flag) => BADGE_ICONS[flag]);
}

export const bitwiseToBadgeLabels = (bitwise) => {
    return bitwiseToBadgeKeys(bitwise).map((flag) => BADGE_LABELS[flag]);
}

export const bitwiseToBadges = (bitwise) => {
    return bitwiseToBadgeKeys(bitwise).map((flag) => ({
            key: flag,
            icon: BADGE_ICONS[flag],
            label: BADGE_LABELS[flag]
        })
    );
}

export const haveFlag = (flags, flag) => {
    return bitwiseToBadgeKeys(flags).includes(flag);
}