// resources/js/Composables/useSubscription.js

import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function useSubscription() {
    const page = usePage();

    const subscription = computed(
        () => page.props.auth.subscription ?? {}
    );

    const isAdmin = computed(
        () => page.props.auth.user?.is_admin ?? false
    );

    const canAccess = (featureSlug) => {
        return (
            isAdmin.value ||
            (subscription.value.feature_access ?? [])
                .includes(featureSlug)
        );
    };

    const getCalculatorRoute = (calculator) => {
        return canAccess(calculator.slug)
            ? route(calculator.route)
            : route('billing.index');
    };

    return {
        subscription,
        isAdmin,
        canAccess,
        getCalculatorRoute,
    };
}