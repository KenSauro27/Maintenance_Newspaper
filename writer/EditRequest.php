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

    public function getIncomingEditRequests($author_id) {
        $sql = "SELECT er.*, u.username, a.title FROM edit_requests er
                JOIN articles a ON er.article_id = a.article_id
                JOIN school_publication_users u ON er.requester_id = u.user_id
                WHERE a.author_id = ?";
        return $this->executeQuery($sql, [$author_id]);
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