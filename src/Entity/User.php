<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(self::ATTR_EMAIL)]
class User implements PasswordAuthenticatedUserInterface
{
    /**
     * Public attributes
     */
    public const ATTR_ID = 'id';

    public const ATTR_NAME = 'name';

    public const ATTR_PASSWORD = 'password';

    public const ATTR_EMAIL = 'email';

    public const ATTR_TYPE = 'type';

    /**
     * Public limits
     */
    public const LIMIT_NAME = 255;

    public const LIMIT_PASSWORD = 255;

    public const LIMIT_EMAIL = 255;

    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: self::LIMIT_NAME)]
    #[Assert\NotBlank]
    private string $name;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: self::LIMIT_PASSWORD)]
    #[Assert\NotBlank]
    private string $password;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: self::LIMIT_EMAIL, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private string $email;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $type;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->{self::ATTR_ID};
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->{self::ATTR_NAME};
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->{self::ATTR_NAME} = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->{self::ATTR_PASSWORD};
    }

    /**
     * @param string|null $password
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->{self::ATTR_PASSWORD} = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->{self::ATTR_EMAIL};
    }

    /**
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->{self::ATTR_EMAIL} = $email;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->{self::ATTR_TYPE};
    }

    /**
     * @param int|null $type
     * @return $this
     */
    public function setType(?int $type): self
    {
        $this->{self::ATTR_TYPE} = $type;

        return $this;
    }
}
