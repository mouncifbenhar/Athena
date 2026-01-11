<?php
class ProjectService {
    private $projectRepository;

    public function __construct($projectRepository) {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects() {
        return $this->projectRepository->getAllProjects();
    }

    public function getProjectDetails($projectId) {
        $project = $this->projectRepository->getProjectById($projectId);
        if ($project) {
            $project['members'] = $this->projectRepository->getProjectMembers($projectId);
        }
        return $project;
    }

    public function createProject($name, $description, $leaderId) {
        return $this->projectRepository->create($name, $description, $leaderId);
    }

    public function updateProject($projectId, $name, $description, $leaderId) {
        return $this->projectRepository->updateProject($projectId, $name, $description, $leaderId);
    }

    public function toggleProjectStatus($projectId) {
        return $this->projectRepository->toggleProjectStatus($projectId);
    }
}
?>