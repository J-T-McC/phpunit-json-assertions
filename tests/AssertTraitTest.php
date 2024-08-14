<?php

/*
 * This file is part of the phpunit-json-assertions package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EnricoStahn\JsonAssert\Tests;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class AssertTraitTest extends TestCase
{
    /**
     * Showcase for the Wiki.
     *
     * @see https://github.com/estahn/phpunit-json-assertions/wiki/assertJsonMatchesSchema
     */
    public function testAssertJsonMatchesSchemaSimpleDraft6()
    {
        $content = json_decode(file_get_contents(Utils::getJsonPath('assertJsonMatchesSchema_simple_draft6.json')));

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"created_at\": \"2016-01-01T12:00:00Z\"}", true]
     * ["{\"created_at\": \"2016/01/01\"}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6DateTime($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"status\": \"active\", \"created_at\": \"2016-01-01T12:00:00Z\"}", true]
     * ["{\"status\": \"completed\", \"created_at\": \"2016-01-01T12:00:00Z\"}", true]
     * ["{\"status\": \"deleted\", \"created_at\": \"2016-01-01T12:00:00Z\"}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6EnumAndNot($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"status\": \"active\", \"created_at\": \"2016-01-01T12:00:00Z\"}", true]
     * ["{\"status\": \"active\"}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6Dependency($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"id\": 2}", true]
     * ["{\"id\": 1}", false]
     * ["{\"id\": 0}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6ExclusiveMinimum($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"title\": \"A brief description\"}", true]
     * ["{\"title\": \"A description that is too long\"}", false]
     * ["{\"title\": \"A\"}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6MaxMinLength($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"invalid_name\": \"value\"}", false]
     */
    public function testAssertJsonMatchesSchemaDraft6AdditionalProperties($json, $pass)
    {
        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    /**
     * @testWith
     * ["{\"status\": \"completed\", \"completed_at\": \"2020-01-01T12:00:00Z\", \"created_at\": \"2020-01-01T12:00:00Z\"}", true]
     * ["{\"status\": \"completed\", \"created_at\": \"2020-01-01T12:00:00Z\"}", false]
     * ["{\"status\": \"pending\", \"expected_completion\": \"2020-01-01T12:00:00Z\", \"created_at\": \"2020-01-01T12:00:00Z\"}", true]
     * ["{\"status\": \"pending\", \"created_at\": \"2020-01-01T12:00:00Z\"}", false]
     * ["{\"status\": \"active\", \"created_at\": \"2020-01-01T12:00:00Z\"}", true]
     */
    public function testAssertJsonMatchesSchemaDraft6Conditional($json, $pass)
    {
        $this->markTestSkipped('Conditional validation is not supported by the current implementation.');

        if (!$pass) {
            $this->expectException(ExpectationFailedException::class);
        }

        $content = json_decode($json);

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_draft6.schema.json')
        );
    }

    public function testAssertJsonMatchesSchemaSimple()
    {
        $content = json_decode(file_get_contents(Utils::getJsonPath('assertJsonMatchesSchema_simple.json')));

        AssertTraitImpl::assertJsonMatchesSchema(
            $content,
            Utils::getSchemaPath('assertJsonMatchesSchema_simple.schema.json')
        );
    }

    public function testAssertJsonMatchesSchema()
    {
        $content = json_decode('{"foo":123}');

        AssertTraitImpl::assertJsonMatchesSchema($content, Utils::getSchemaPath('test.schema.json'));
    }

    public function testAssertJsonMatchesSchemaFail()
    {
        $this->expectException(ExpectationFailedException::class);
        $content = json_decode('{"foo":"123"}');

        AssertTraitImpl::assertJsonMatchesSchema($content, Utils::getSchemaPath('test.schema.json'));
    }

    public function testAssertThrowsFileNotFoundException()
    {
        $this->expectException(FileNotFoundException::class);
        $content = json_decode('{"foo":"123"}');

        AssertTraitImpl::assertJsonMatchesSchema($content, 'not-found.json');
    }

    public function testAssertJsonMatchesSchemaFailMessage()
    {
        $content = json_decode('{"foo":"123"}');

        $exception = null;

        try {
            AssertTraitImpl::assertJsonMatchesSchema($content, Utils::getSchemaPath('test.schema.json'));
        } catch (ExpectationFailedException $exception) {
            self::assertStringContainsString(
                '- Property: foo, Constraint: type, Message: String value found, but an integer is required',
                $exception->getMessage()
            );
            self::assertStringContainsString('- Response: {"foo":"123"}', $exception->getMessage());
        }

        self::assertInstanceOf('\PHPUnit\Framework\ExpectationFailedException', $exception);
    }

    /**
     * Tests if referenced schemas are loaded automatically.
     */
    public function testAssertJsonMatchesSchemaWithRefs()
    {
        $content = json_decode('{"code":123, "message":"Nothing works."}');

        AssertTraitImpl::assertJsonMatchesSchema($content, Utils::getSchemaPath('error.schema.json'));
    }

    public function testAssertJsonMatchesSchemaWithRefsFails()
    {
        $this->expectException(ExpectationFailedException::class);
        $content = json_decode('{"code":"123", "message":"Nothing works."}');

        AssertTraitImpl::assertJsonMatchesSchema($content, Utils::getSchemaPath('error.schema.json'));
    }

    public function testAssertJsonMatchesSchemaString()
    {
        $content = json_decode('{"foo":123}');
        $schema = file_get_contents(Utils::getSchemaPath('test.schema.json'));

        AssertTraitImpl::assertJsonMatchesSchemaString($schema, $content);
    }

    /**
     * Tests assertJsonValueEquals().
     *
     * @dataProvider assertJsonValueEqualsProvider
     *
     * @param string $expression
     * @param mixed  $value
     */
    public function testAssertJsonValueEquals(string $expression, $value)
    {
        $content = json_decode(file_get_contents(Utils::getJsonPath('testAssertJsonValueEquals.json')));

        AssertTraitImpl::assertJsonValueEquals($value, $expression, $content);
    }

    public function testAssertWithSchemaStore()
    {
        $obj = new AssertTraitImpl('testAssertWithSchemaStore');
        $obj->setUp();

        $schemaStore = $obj->testWithSchemaStore('foobar', (object) ['type' => 'string']);

        self::assertInstanceOf('JsonSchema\SchemaStorage', $schemaStore);
        self::assertEquals($schemaStore->getSchema('foobar'), (object) ['type' => 'string']);
    }

    public static function assertJsonValueEqualsProvider(): array
    {
        return [
            ['foo', '123'],
            ['a.b.c[0].d[1][0]', 1],
        ];
    }

    public function testAssertJsonValueEqualsFailsOnWrongDataType()
    {
        $this->expectException(ExpectationFailedException::class);
        $content = json_decode(file_get_contents(Utils::getJsonPath('testAssertJsonValueEquals.json')));

        AssertTraitImpl::assertJsonValueEquals($content, 'a.b.c[0].d[1][0]', '{}');
    }

    /**
     * @dataProvider jsonObjectProvider
     */
    public function testGetJsonObject($expected, $actual)
    {
        self::assertEquals($expected, AssertTraitImpl::getJsonObject($actual));
    }

    public static function jsonObjectProvider(): array
    {
        return [
            [[], []],
            [[], '[]'],
            [new \stdClass(), new \stdClass()],
            [new \stdClass(), '{}'],
        ];
    }
}
