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

    /**
     * Execução de comando HEAD.
     */
	const RequestHEAD = "RequestHEAD";

    /**
     * Execução de comando GET.
     */
	const RequestGET = "RequestGET";

    /**
     * Execução de comando POST.
     */
	const ExecutePOST = "ExecutePOST";

    /**
     * Execução de comando PUT.
     */
	const ExecutePUT = "ExecutePUT";

    /**
     * Execução de comando PATCH.
     */
	const ExecutePATCH = "ExecutePATCH";

    /**
     * Execução de comando DELETE.
     */
	const ExecuteDELETE = "ExecuteDELETE";

    /**
     * Execução de comando OPTIONS.
     */
	const ExecuteOPTIONS = "ExecuteOPTIONS";

    /**
     * Execução de comando TRACE.
     */
	const ExecuteTRACE = "ExecuteTRACE";

    /**
     * Execução de comando CONNECT.
     */
	const ExecuteCONNECT = "ExecuteCONNECT";

    /**
     * Execução de UPLOAD de arquivos.
     */
	const ExecuteUPLOAD = "ExecuteUPLOAD";
}
