<?php

namespace Teste\Unit\UseCase\Category;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $this->assertTrue(true);
    }

    public function testNotNull()
    {
        try{
            $value = '';
            DomainValidation::notNull($value);
            $this->assertTrue(false);

        }catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th );
        }
    }
    public function testNotNullCustomMessageExeption()
    {
        try{
            $value = '';
            DomainValidation::notNull($value, 'Não pode ser vazio');
            $this->assertTrue(false);

        }catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Não pode ser vazio' );
        }
    }

    public function testStrMaxLength()
    {
        try{
            $value = 'Fabio';
            DomainValidation::strMaxLength($value,  5, 'Erro ao validar');
            $this->assertTrue(false);

        }catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Erro ao validar');
        }
    }
    public function testStrMinLength()
    {
        try{
            $value = 'Fabio';
            DomainValidation::strMinLength($value,  6, 'Erro ao validar');
            $this->assertTrue(false);

        }catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Erro ao validar');
        }
    }

    public function  testStrCanNullAndMaxLength()
    {
        try{
            $value = 'teste';
            DomainValidation::strCanNullAndMaxLength($value, 3, 'Erro ao validar');
            $this->assertTrue(false);
        } catch (\Throwable $th){
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Erro ao validar');
        }
    }
}
