<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *     "id",
 *     "firstName",
 *     "lastName",
 *     "company",
 *     "updatedAt"
 *     },
 *     arguments={"orderParameterName"="sortby"}
 * )
 * @ApiFilter(
 *     SearchFilter::Class,
 *     properties={
 *     "id": "exact",
 *     "firstName": "partial",
 *     "lastName": "partial",
 *     "company": "exact",
 *     "phone": "partial"
 *     }
 * )
 * @ApiResource(
 *
 *     collectionOperations={
 *     "get"={"path" = "/customers/list"},
 *     "post"={"path" = "/customers/create"}
 *     },
 *     itemOperations={"get",
 *     "put" = {"path" = "/customers/update/{id}"},
 *     "delete" = {"path" = "/customers/delete/{id}"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository", repositoryClass=CustomerRepository::class)
 * @UniqueEntity(fields={"email"}, message="The email has been registered, please enter a new email")
 */
class Customer implements UpdatedAtDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string $street;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(min="4")
     * @Assert\Regex(pattern="/\d{4,10}/", message="Please enter valid zip code")
     */
    private string $zip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="The phone number should not be blank.")
     * @Assert\Length(min="7")
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="You should enter a valid email")
     * @Assert\NotBlank()
     */
    private string $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): UpdatedAtDateEntityInterface
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
