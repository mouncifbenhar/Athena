<?php
class Project {
    private $id;
    private $name;
    private $description;
    private $leaderId;
    private $isActive;

    public function __construct($id, $name, $description, $leaderId, $isActive) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->leaderId = $leaderId;
        $this->isActive = $isActive;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getLeaderId() { return $this->leaderId; }
    public function isActive() { return $this->isActive; }
}