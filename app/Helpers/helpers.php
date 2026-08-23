<?php

if (!function_exists('formatCpf')) {
    function formatCpf($cpf)
    {
        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            $cpf
        );
    }
}

if (!function_exists('formatPhone')) {
    function formatPhone($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) === 11) {
            return preg_replace(
                '/(\d{2})(\d{5})(\d{4})/',
                '($1) $2-$3',
                $phone
            );
        }

        if (strlen($phone) === 10) {
            return preg_replace(
                '/(\d{2})(\d{4})(\d{4})/',
                '($1) $2-$3',
                $phone
            );
        }

        return $phone;
    }
}

if (!function_exists('formatCep')) {
    function formatCep($cep)
    {
        $cep = preg_replace('/\D/', '', $cep);

        return preg_replace(
            '/(\d{5})(\d{3})/',
            '$1-$2',
            $cep
        );
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return 'R$ ' . number_format(
            $price,
            2,
            ',',
            '.'
        );
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'd/m/Y'): string
    {
        if (!$date) {
            return '';
        }

        return \Carbon\Carbon::parse($date)->format($format);
    }
}