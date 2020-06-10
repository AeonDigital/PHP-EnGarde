<?php
declare (strict_types=1);

namespace AeonDigital\EnGarde\SessionControl\Enum;





/**
 * Status relativo as verificações de segurança.
 */
class SecurityStatus
{
    /**
     * Verificações de segurança não foram feitos para o UA.
     *
     * @var         string
     */
    const UserAgentUndefined = "UserAgentUndefined";
    /**
     * O UA está usando um IP que está bloqueado.
     *
     * @var         string
     */
	const UserAgentIPBlocked = "UserAgentIPBlocked";
    /**
     * O UA está usando um IP válido.
     *
     * @var         string
     */
	const UserAgentIPValid = "UserAgentIPValid";





    /**
     * Sessão indefinida.
     *
     * @var         string
     */
    const SessionUndefined = "SessionUndefined";
    /**
     * Sessão definida mas não verificada.
     *
     * @var         string
     */
    const SessionUnchecked = "SessionUnchecked";
    /**
     * A sessão informada é inválida ou não pode ser encontrada.
     *
     * @var         string
     */
	const SessionInvalid = "SessionInvalid";
    /**
     * IP do UA não é compativel com o valor armazenado em sua sessão.
     *
     * @var         string
     */
	const SessionUnespectedUserAgentIP = "SessionUnespectedUserAgentIP";
    /**
     * Identificação do UA não é compativel com o valor armazenado em sua sessão.
     *
     * @var         string
     */
	const SessionUnespectedUserAgent = "SessionUnespectedUserAgent";
    /**
     * Aplicação indicada não é compativel com o valor armazenado em sua sessão.
     *
     * @var         string
     */
	const SessionUnespectedApplication = "SessionUnespectedApplication";
    /**
     * Sessão do UA expirou.
     *
     * @var         string
     */
	const SessionExpired = "SessionExpired";
    /**
     * Sessão válida.
     *
     * @var         string
     */
	const SessionValid = "SessionValid";





    /**
     * Conta de usuário não existe.
     *
     * @var         string
     */
	const UserAccountDoesNotExist = "UserAccountDoesNotExist";
    /**
     * Conta de usuário existe mas não pode ser verificada.
     *
     * @var         string
     */
	const UserAccountUnchecked = "UserAccountUnchecked";
    /**
     * Conta do usuário está desabilitada dentro deste domínio.
     *
     * @var         string
     */
	const UserAccountDisabledForDomain = "UserAccountDisabledForDomain";
    /**
     * Conta de usuário não existe para a aplicação alvo.
     *
     * @var         string
     */
	const UserAccountDoesNotExistInApplication = "UserAccountDoesNotExistInApplication";
    /**
     * Conta do usuário está desabilitada dentro da aplicação alvo.
     *
     * @var         string
     */
	const UserAccountDisabledForApplication = "UserAccountDisabledForApplication";
    /**
     * Conta do usuário está desabilitada dentro deste domínio.
     *
     * @var         string
     */
	const UserAccountRecognizedAndActive = "UserAccountRecognizedAndActive";
    /**
     * Conta de usuário existe, autenticada e aguardando uma sessão de autorização.
     *
     * @var         string
     */
	const UserAccountWaitingNewSession = "UserAccountWaitingNewSession";
    /**
     * Conta do usuário existe mas a senha não está correta.
     *
     * @var         string
     */
	const UserAccountUnexpectedPassword = "UserAccountUnexpectedPassword";
    /**
     * Conta do usuário está bloqueada.
     *
     * @var         string
     */
	const UserAccountIsBlocked = "UserAccountIsBlocked";
    /**
     * Conta desabilitada por excesso de falhas ao tentar login.
     *
     * @var         string
     */
	const UserAccountHasBeenBlocked = "UserAccountHasBeenBlocked";





    /**
     * Conta de usuário não teve sua sessão verificada.
     *
     * @var         string
     */
    const UserSessionUnchecked = "UserSessionUnchecked";
    /**
     * Conta de usuário está vinculada a uma sessão diferente da sessão apresentada
     * por seu cookie de segurança.
     *
     * @var         string
     */
    const UserSessionUnespected = "UserSessionUnespected";
    /**
     * Conta de usuário não teve sua sessão verificada.
     *
     * @var         string
     */
    const UserSessionAccepted = "UserSessionAccepted";



    /**
     * Ocorreu uma falha no sistema durante a tentativa de login.
     *
     * @var         string
     */
	const UserSessionLoginFail = "UserSessionLoginFail";
    /**
     * Sessão do usuário está autenticada.
     *
     * @var         string
     */
	const UserSessionAuthenticated = "UserSessionAuthenticated";
}
