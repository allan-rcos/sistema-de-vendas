<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

#[AsCommand(
    name: 'app:register',
    description: 'Registra um novo usuário',
)]
class RegisterCommand extends Command
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Seu melhor email.')
            ->addArgument('password', InputArgument::REQUIRED, 'A senha para este usuário')
            ->addArgument('repeat', InputArgument::REQUIRED, 'Repita a senha.')
            ->addArgument('name', InputArgument::REQUIRED, 'O nome do novo usuário.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        extract($input->getArguments(), EXTR_PREFIX_SAME, "wddx");

        $invalidMessage = [];

        if ($password !== $repeat)
            $invalidMessage[] = "As senhas não coincidem.";
        else if (strlen($password) < 8)
            $invalidMessage[] = "Senha muito curta: mínimo de 8 caracteres.";
        else if (!preg_match("/^(?=.*[A-Z])(?=.*[!#@$^%&])(?=.*[0-9])(?=.*[a-z]).{6,15}$/", $password))
            $invalidMessage[] = "Senha deve conter pelo menos um digito, uma letra maiúscula, uma minúscula e um caractere especial ($*&@#).";

        if(!$email)
            $invalidMessage[] = "Email é obrigatório.";
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $invalidMessage[] = "Email Inválido";

        if(!$name)
            $invalidMessage[] = "Nome é obrigatório.";
        else if (!preg_match("/^[A-zÀ-ú ]+$/", $name))
            $invalidMessage[] = "Nome inválido: apenas caracteres alfabéticos, espaços e acentuações são aceitos.";

        if ($invalidMessage) {
            foreach ($invalidMessage as $message){
                $io->error($message);
            }

            return Command::INVALID;
        }

        $user = $this->repository->findOneBy(["email" => $email]);

        if ($user) {
            $io->error("Esse usuário já está registrado.");

            return Command::FAILURE;
        }

        $io->comment("Criando o usuário...");

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );
        $user->setName($name);

        $this->em->persist($user);
        $this->em->flush();

        $io->success('Usuário criado com sucesso!');

        return Command::SUCCESS;
    }
}
