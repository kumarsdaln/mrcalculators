import { usePage } from '@inertiajs/vue3';

export function useCalculator(slug) {
    const page = usePage();
    const calculators = page.props.catalog?.calculators ?? [];

    return calculators.find(
        calculator => calculator.slug === slug
    );
}
