<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl\Enum;










/**
 * Possíveis status para uma ação de login.
 */
class LoginStatus {

    /**
     * Usuário anônimo.
     */
	const Anonimous = "Anonimous";

    /**
     * Usuário autorizado.
     */
	const Authorized = "Authorized";

    /**
     * IP do usuário está na lista dos bloqueados.
     */
	const BlockedIP = "BlockedIP";

    /**
     * Usuário está na lista dos bloqueados.
     */
	const BlockedUser = "BlockedUser";

    /**
     * Conta de usuário não existe na base de dados.
     */
	const AccountDoesNotExist = "AccountDoesNotExist";

    /**
     * Conta do usuário existe mas a senha não está correta.
     */
	const UnexpectedPassword = "UnexpectedPassword";

    /**
     * Conta do usuário está desabilitada dentro deste domínio.
     */
	const AccountDisabledForDomain = "AccountDisabledForDomain";

    /**
     * Conta do usuário está desabilitada dentro deste domínio.
     */
	const AccountRecognizedAndActive = "AccountRecognizedAndActive";

    /**
     * Conta de usuário existe e está habilitada para o domínio restando autenticação da aplicação alvo.
     */
	const WaitingApplicationAuthenticate = "WaitingApplicationAuthenticate";

    /**
     * Conta de usuário não existe para a aplicação alvo.
     */
	const AccountDoesNotExistInApplication = "AccountDoesNotExistInApplication";

    /**
     * Conta do usuário está desabilitada dentro da aplicação alvo.
     */
	const AccountDisabledForApplication = "AccountDisabledForApplication";

    /**
     * Seu IP será bloqueado por excesso de falhas ao tentar login.
     */
	const YourIPIsBlocked = "YourIPIsBlocked";

    /**
     * Conta desabilitada por excesso de falhas ao tentar login.
     */
	const AccountIsBlocked = "AccountIsBlocked";

    /**
     * Ocorreu uma falha no sistema durante a tentativa de login.
     */
	const LoginFail = "LoginFail";
}
