<?php

namespace App\Dtos;

use Illuminate\Contracts\Support\Arrayable;

class Task implements Arrayable
{
    /** @var string */
    private string $title;

    /** @var string */
    private string $subTitle;

    /** @var string */
    private string $description;

    /** @var string */
    private string $repetitions;

    /** @var string */
    private string $tool;

    /** @var array */
    private array $samples = [];

    /** @var string */
    private string $video;


    /**
     * create Method.
     *
     * @return Task
     */
    public static function create(): Task
    {
        return new Task();
    }

    /**
     * @param string $title
     * @return Task
     */
    public function setTitle(string $title): Task
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $subTitle
     * @return Task
     */
    public function setSubTitle(string $subTitle): Task
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    /**
     * @param string $description
     * @return Task
     */
    public function setDescription(string $description): Task
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $repetitions
     * @return Task
     */
    public function setRepetitions(string $repetitions): Task
    {
        $this->repetitions = $repetitions;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepetitions(): string
    {
        return $this->repetitions;
    }

    /**
     * @param string $tool
     * @return Task
     */
    public function setTool(string $tool): Task
    {
        $this->tool = $tool;
        return $this;
    }

    /**
     * @return string
     */
    public function getTool(): string
    {
        return $this->tool;
    }

    /**
     * @param string $image
     * @return Task
     */
    public function setSamples(string $image): Task
    {
        $this->samples[] = $image;
        return $this;
    }

    /**
     * @return array
     */
    public function getSamples(): array
    {
        return $this->samples;
    }

    /**
     * getSampleText Method.
     *
     * @return string
     */
    public function getSampleText(): string
    {
        return implode(PHP_EOL, $this->samples);
    }

    /**
     * @param string $video
     * @return Task
     */
    public function setVideo(string $video): Task
    {
        $this->video = $video;
        return $this;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * first Method.
     *
     * @return array
     */
    public function first(): array
    {
        return $this->toArray()[0];
    }

    /**
     * getHeaders Method.
     *
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'Title',
            'Sub Title',
            'Description',
            'Repetitions',
            'Tool',
            'Samples',
            'Videos',
        ];
    }

    /**
     * toArray Method.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            [
                'title' => $this->getTitle(),
                'sub_itle' => $this->getSubTitle(),
                'description' => $this->getDescription(),
                'repetitions' => $this->getRepetitions(),
                'tool' => $this->getTool(),
                'samples' => $this->getSampleText(),
                'videos' => $this->getVideo(),
            ]
        ];
    }
}
