<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl\Enum;





/**
 * Status de navegação.
 */
class BrowseStatus
{
    /**
     * Status de navegação não verificado.
     *
     * @var         string
     */
	const Unchecked = "Unchecked";
    /**
     * Atatus da navegação verificada e autorizada.
     *
     * @var         string
     */
	const Authorized = "Authorized";
}
