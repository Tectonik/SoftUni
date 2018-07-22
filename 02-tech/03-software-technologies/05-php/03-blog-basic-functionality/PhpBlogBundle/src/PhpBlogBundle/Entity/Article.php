<?php

namespace PhpBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="PhpBlogBundle\Repository\ArticleRepository")
 */
class Article
{
	public function __construct()
	{
		$this->dateAdded = new \DateTime('now');
	}

	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="content", type="text")
	 */
	private $content;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="dateAdded", type="datetime")
	 */
	private $dateAdded;

	/**
	 * @var string
	 */
	private $summary;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="authorId", type="integer")
	 */
	private $authorId;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="PhpBlogBundle\Entity\User", inversedBy="articles")
	 * @ORM\JoinColumn(name="authorId",referencedColumnName="id")
	 */
	private $author;

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Article
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 *
	 * @return Article
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set dateAdded
	 *
	 * @param \DateTime $dateAdded
	 *
	 * @return Article
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;

		return $this;
	}

	/**
	 * Get dateAdded
	 *
	 * @return \DateTime
	 */
	public function getDateAdded()
	{
		return $this->dateAdded;
	}

	/**
	 * @return string
	 */
	public function getSummary()
	{
		if ($this->summary === null)
		{
			$this->setSummary();
		}

		return $this->summary;
	}

	/**
	 * @param string $summary
	 */
	public function setSummary()
	{
		$this->summary = substr($this->content, 0, 100) . "...";
	}

	/**
	 * @return int
	 */
	public function getAuthorId()
	{
		return $this->authorId;
	}

	/**
	 * @param int $authorId
	 *
	 * @return Article
	 */
	public function setAuthorId($authorId)
	{
		$this->authorId = $authorId;
		return $this;
	}

	/**
	 * @return \PhpBlogBundle\Entity\User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param \PhpBlogBundle\Entity\User $author
	 *
	 * @return Article;
	 */
	public function setAuthor(User $author = null)
	{
		$this->author = $author;

		return $this;
	}
}

