<?php

namespace App\Traits;

use App\Models\ActivityLogModel;

trait ActivityLoggable
{
    protected $activityLogModel;

    protected function initializeActivityLog()
    {
        if (!isset($this->activityLogModel)) {
            $this->activityLogModel = new \App\Models\ActivityLogModel();
        }
    }

    /**
     * Override insert method to log activity and create notifications
     */
    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);

        if ($result !== false) {
            $userId = session()->get('idUsuario') ?? null;

            // Log the activity
            $this->activityLogModel->logActivity(
                $this->table,
                $result,
                'INSERT',
                null,
                $data,
                $userId
            );

            // Create notifications for relevant users
            $this->createNotification([
                'table_name' => $this->table,
                'record_id' => $result,
                'action' => 'INSERT',
                'old_values' => null,
                'new_values' => json_encode($data),
                'user_id' => $userId
            ]);
        }

        return $result;
    }

    /**
     * Override update method to log activity and create notifications
     */
    public function update($id = null, $data = null): bool
    {
        // Get old data before update
        $oldData = null;
        if ($id !== null) {
            $oldData = $this->find($id);
        }

        $result = parent::update($id, $data);

        if ($result) {
            $userId = session()->get('idUsuario') ?? null;

            // Log the activity
            $this->activityLogModel->logActivity(
                $this->table,
                $id,
                'UPDATE',
                $oldData,
                $data,
                $userId
            );

            // Create notifications for relevant users
            $this->createNotification([
                'table_name' => $this->table,
                'record_id' => $id,
                'action' => 'UPDATE',
                'old_values' => json_encode($oldData),
                'new_values' => json_encode($data),
                'user_id' => $userId
            ]);
        }

        return $result;
    }

    /**
     * Override delete method to log activity and create notifications
     */
    public function delete($id = null, bool $purge = false)
    {
        // Get old data before delete
        $oldData = null;
        if ($id !== null) {
            $oldData = $this->find($id);
        }

        $result = parent::delete($id, $purge);

        if ($result) {
            $userId = session()->get('idUsuario') ?? null;

            // Log the activity
            $this->activityLogModel->logActivity(
                $this->table,
                $id,
                'DELETE',
                $oldData,
                null,
                $userId
            );

            // Create notifications for relevant users
            $this->createNotification([
                'table_name' => $this->table,
                'record_id' => $id,
                'action' => 'DELETE',
                'old_values' => json_encode($oldData),
                'new_values' => null,
                'user_id' => $userId
            ]);
        }

        return $result;
    }

    /**
     * Create notification for the activity
     */
    protected function createNotification($activityData)
    {
        try {
            // Check if this activity should create a notification
            if ($this->shouldCreateNotification($activityData)) {
                // Load NotificationModel and create notification directly for this specific activity
                $notificationModel = new \App\Models\NotificationModel();
                $notificationModel->createNotificationForActivity($activityData);
            }
        } catch (\Exception $e) {
            // Log error but don't break the main operation
            log_message('error', 'Failed to create notification: ' . $e->getMessage());
        }
    }

    /**
     * Determine if an activity should create a notification
     */
    protected function shouldCreateNotification($activity)
    {
        // All activities should create notifications
        return true;
    }
}
