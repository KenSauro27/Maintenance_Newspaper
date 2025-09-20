<?php

require_once 'Database.php';

class EditRequest extends Database {

    public function createEditRequest($article_id, $requester_id) {
        $sql = "INSERT INTO edit_requests (article_id, requester_id) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $requester_id]);
    }

    public function getEditRequestsForArticle($article_id) {
        $sql = "SELECT * FROM edit_requests WHERE article_id = ?";
        return $this->executeQuery($sql, [$article_id]);
    }

    public function getEditRequestsFromUser($requester_id) {
        $sql = "SELECT * FROM edit_requests WHERE requester_id = ?";
        return $this->executeQuery($sql, [$requester_id]);
    }

    public function getEditRequests() {
        $sql = "SELECT * FROM edit_requests";
        return $this->executeQuery($sql);
    }

    public function updateEditRequestStatus($request_id, $status) {
        $sql = "UPDATE edit_requests SET status = ? WHERE request_id = ?";
        return $this->executeNonQuery($sql, [$status, $request_id]);
    }
}
?>