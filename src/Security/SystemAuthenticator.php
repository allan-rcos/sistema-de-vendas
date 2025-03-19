<?php

namespace App\Security;

use App\Form\LoginForm;
use App\Form\Model\LoginFormModel;
use Composer\Pcre\UnexpectedNullMatchException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SystemAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{

    use TargetPathTrait;

    private ?FormInterface $form = null;

    function __construct(
        private readonly FormFactoryInterface $formFactor,
        private readonly RouterInterface $router,
        private readonly RequestStack $requestStack
    ){

    }

    public function supports(Request $request): ?bool
    {
        $this->form = $this->getForm($request);

        return ($this->form->isSubmitted() && $this->form->isValid());
    }

    public function authenticate(Request $request): Passport
    {
        if (!$this->form) throw new UnexpectedNullMatchException("Form variable is null.");

        /* @var $data LoginFormModel */
        $data = $this->form->getData();
        $formConfig = $this->form->getConfig();
        $badges = [
            new CsrfTokenBadge(
                $formConfig->getAttribute("csrf_token_id"),
                $request->request->all()[$this->form->getName()][$formConfig->getOption("csrf_field_name")]
            )
        ];

        if ($data->rememberMe)
            $badges[] = (new RememberMeBadge())->enable();

        return new Passport(
            new UserBadge($data->email),
            new PasswordCredentials($data->password),
            $badges
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->addFlash("success", "Logado com sucesso.");

        if ($target = $this->getTargetPath($request->getSession(), $firewallName))
            return new RedirectResponse($target);

        return new RedirectResponse(
            $this->router->generate('Home')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->addFlash("error", $exception->getMessage());

        return new RedirectResponse(
            $this->router->generate('Login')
        );
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            $this->router->generate('Login')
        );
    }

    private function getForm(Request $request): FormInterface
    {
        $form = $this->formFactor->create(LoginForm::class);
        $form->handleRequest($request);
        return $form;
    }

    /**
     * Adds a flash message to the current session for type.
     *
     * @throws \LogicException
     */
    protected function addFlash(string $type, mixed $message): void
    {
        try {
            $session = $this->requestStack->getSession();
        } catch (SessionNotFoundException $e) {
            throw new \LogicException('You cannot use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".', 0, $e);
        }

        if (!$session instanceof FlashBagAwareSessionInterface) {
            throw new \LogicException(\sprintf('You cannot use the addFlash method because class "%s" doesn\'t implement "%s".', get_debug_type($session), FlashBagAwareSessionInterface::class));
        }

        $session->getFlashBag()->add($type, $message);
    }
}
