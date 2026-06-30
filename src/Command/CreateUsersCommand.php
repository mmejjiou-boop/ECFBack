<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-users',
    description: 'Crée les utilisateurs admin et gestionnaire',
)]
class CreateUsersCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $hasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $admin = new User();
        $admin->setEmail('admin@asso.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'password'));
        $this->em->persist($admin);

        $gestionnaire = new User();
        $gestionnaire->setEmail('gestionnaire@asso.fr');
        $gestionnaire->setRoles(['ROLE_GESTIONNAIRE']);
        $gestionnaire->setPassword($this->hasher->hashPassword($gestionnaire, 'password'));
        $this->em->persist($gestionnaire);

        $this->em->flush();

        $io->success('Utilisateurs créés : admin@asso.fr et gestionnaire@asso.fr (mot de passe : password)');

        return Command::SUCCESS;
    }
}