import calculatorData from '@/data/calculators';

export function useCalculator(slug) {
    return calculatorData.calculators.find(
        calculator => calculator.slug === slug
    );
}