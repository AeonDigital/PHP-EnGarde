<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl\Enum;










/**
 * Status de navegação.
 */
class BrowseStatus {

    /**
     * Status de navegação não verificado.
     */
	const Unchecked = "Unchecked";

    /**
     * Usuário autorizado.
     */
	const Authorized = "Authorized";

    /**
     * IP do usuário está na lista dos bloqueados.
     */
	const BlockedIP = "BlockedIP";

    /**
     * Ticket de Autenticação não existente.
     */
	const DoesNotExistTicketAuthentication = "DoesNotExistTicketAuthentication";

    /**
     * Ticket de Autenticação não foi reconhecido como válido.
     */
	const InvalidTicketAuthentication = "InvalidTicketAuthentication";

    /**
     * A sessão informada é inválida ou não pode ser encontrada.
     */
	const InvalidSession = "InvalidSession";

    /**
     * IP do usuário não é compativel com o valor armazenado em sua sessão.
     */
	const UnespectedIP = "UnespectedIP";

    /**
     * Navegador do usuário não é compativel com o valor armazenado em sua sessão.
     */
	const UnespectedBrowser = "UnespectedBrowser";

    /**
     * Sessão do usuário expirou.
     */
	const ExpiredSession = "ExpiredSession";

    /**
     * Usuário não tem acesso a seção.
     */
	const SectionDenied = "SectionDenied";

    /**
     * Usuário não tem acesso à action/page.
     */
	const ActionDenied = "ActionDenied";

    /**
     * Usuário não tem acesso à seção de dados.
     */
	const DataSectionDenied = "DataSectionDenied";
}
