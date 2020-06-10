<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl\Enum;





/**
 * Tipo de atividade para log.
 */
class TypeOfActivity {

    /**
     * Ação generica.
     */
	const Generic = "Generic";

    /**
     * Tentativa de Login.
     */
	const MakeLogin = "MakeLogin";

    /**
     * Tentativa de Logout.
     */
	const MakeLogout = "MakeLogout";

    /**
     * Gerar nova senha.
     */
	const GenerateNewPassword = "GenerateNewPassword";
}
