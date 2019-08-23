<?php

namespace App\Models;

use DateTime;

/**
 * Class for post object defining a post
 */
class Post
{
    private $errors = [];
    private $id;
    private $name;
    private $image;
    private $idauthor;
    private $title;
    private $kicker;
    private $content;
    private $publishDate;
    private $updateDate;
    private $countComment;

    const IDAUTHOR_INVALID = 1;
    const TITLE_INVALID = 2;
    const KICKER_INVALID = 3;
    const CONTENT_INVALID = 4;
    const CONTENT_LENGHT = 5;
    const KICKER_LENGHT = 6;
    const TITLE_LENGHT = 7;

    public function __construct(array $values = [])
    {
        if (!empty($values)) {
            $this->hydrate($values);
        }
    }

    /**
     * Hydrate the object with data
     * @param  array $data Usually from post form when add or update post
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }

    /**
     * Check if object is new
     * @return bool true if new, false if not new
     */
    public function isNew() :bool
    {
        return empty($this->id);
    }

    /**
     * Check if object is valid
     * @return bool true if every item is not empty, false if at least one item is empty
     */
    public function isValid() :bool
    {
        return !(empty($this->idauthor) || empty($this->title) || empty($this->kicker) || empty($this->content));
    }

    // Setters

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * Set name, is not a string or empty, new error.
     * @param string $name name of the post
     */
    public function setname($name)
    {
        $this->name = $name;
    }


    /**
     * Set image, is not a string or empty, new error.
     * @param string $image Image of the post
     */
    public function setimage($image)
    {
        $this->image = $image;
    }


    /**
     * Set id author, is not a string or empty, new error.
     * @param string $idauthor Id author of the post
     */
    public function setIdAuthor($idauthor)
    {
        if (!(int)$idauthor || empty($idauthor)) {
            $this->errors[] = self::IDAUTHOR_INVALID;
        } else {
            $this->idauthor = $idauthor;
        }
    }

    /**
     * Set title, is not a string or empty, new error.
     * @param string $title Title of the post
     */
    public function setTitle($title)
    {
        if (!is_string($title) || empty($title)) {
            $this->errors[] = self::TITLE_INVALID;
        } elseif (!empty($title) && (strlen($title) < 10 || strlen($title) > 500)) {
            $this->errors[] = self::TITLE_LENGHT;
        } else {
            $this->title = $title;
        }
    }

    /**
     * Set Kicker, is not a string or empty, new error.
     * @param string $kicker Kicker of the post
     */
    public function setKicker($kicker)
    {
        if (!is_string($kicker) || empty($kicker)) {
            $this->errors[] = self::KICKER_INVALID;
        } elseif (!empty($kicker) && (strlen($kicker) < 10 || strlen($kicker) > 500)) {
            $this->errors[] = self::KICKER_LENGHT;
        } else {
            $this->kicker = $kicker;
        }
    }

    /**
     * Set content, is not a string or empty, new error.
     * @param string $content Content of the post
     */
    public function setContent($content)
    {
        if (!is_string($content) || empty($content)) {
            $this->errors[] = self::CONTENT_INVALID;
        } elseif (!empty($content) && (strlen($content) < 10 || strlen($content) > 50000)) {
            $this->errors[] = self::CONTENT_LENGHT;
        } else {
            $this->content = $content;
        }
    }

    public function setPublishDate(DateTime $publishDate)
    {
        $this->publishDate = $publishDate;
    }

    public function setUpdatDate(DateTime $updateDate)
    {
        $this->updateDate = $updateDate;
    }

    public function setCountComment($countComment)
    {
        $this->countComment = $countComment;
    }


    // Getters

    public function errors()
    {
        return $this->errors;
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function image()
    {
        return $this->image;
    }

    public function name() :?string
    {
        return $this->name;
    }

    public function idauthor() :int
    {
        return $this->idauthor;
    }

    public function kicker()
    {
        return $this->kicker;
    }

    public function content()
    {
        return $this->content;
    }

    public function publishDate()
    {
        return $this->publishDate;
    }

    public function updateDate()
    {
        return $this->updateDate;
    }

    public function countComment()
    {
        if ($this->countComment == 0) {
            return null;
        }
        return $this->countComment;
    }
}
