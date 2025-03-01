<?php // lint >= 8.1

declare(strict_types=1);

namespace InArrayEnum;

use function PHPStan\Testing\assertType;

enum FooUnitEnum
{
	case A;
	case B;
}

class Foo
{

	public function looseCheckEnumSpecifyNeedle(mixed $v): void
	{
		if (in_array($v, FooUnitEnum::cases())) {
			assertType('InArrayEnum\FooUnitEnum::A|InArrayEnum\FooUnitEnum::B', $v);

			if (in_array($v, ['A', null, FooUnitEnum::B])) {
				assertType('InArrayEnum\FooUnitEnum::B', $v);
			}
		}

	}

	/** @param array<FooUnitEnum|int> $haystack */
	public function looseCheckEnumSpecifyHaystack(array $haystack): void
	{
		if (! in_array(FooUnitEnum::A, $haystack)) {
			assertType('array<InArrayEnum\FooUnitEnum::B|int>', $haystack);
		}

		if (! in_array(rand() ? FooUnitEnum::A : FooUnitEnum::B, $haystack, true)) {
			assertType('array<InArrayEnum\FooUnitEnum|int>', $haystack);
		}

		if (! in_array(rand() ? 5 : 6, $haystack, true)) {
			assertType('array<InArrayEnum\FooUnitEnum|int>', $haystack);
		}

		if (! in_array(rand() ? 5 : rand(), $haystack, true)) {
			assertType('array<InArrayEnum\FooUnitEnum|int>', $haystack);
		}
	}

	/** @param array<FooUnitEnum|string|null> $haystack */
	public function skipUnsafeLooseComparison(?FooUnitEnum $v, array $haystack): void
	{
		if (in_array($v, $haystack, false)) {
			assertType('InArrayEnum\FooUnitEnum|null', $v);
		}
	}

}
