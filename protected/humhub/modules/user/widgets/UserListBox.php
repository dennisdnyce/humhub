<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\widgets;

/**
 * UserListBox returns the content of the user list modal
 * 
 * Example Action:
 * 
 * ```php
 * public actionUserList() {
 *       $query = User::find();
 *       $query->where(...);
 *        
 *       $title = "Some Users";
 *  
 *       return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
 * }
 * ```
 *
 * @author luke
 */
class UserListBox extends \yii\base\Widget
{

    /**
     * @var \yii\db\ActiveQuery
     */
    public $query;

    /**
     * @var string title of the box
     */
    public $title = 'Users';

    /**
     * @var int displayed users per page
     */
    public $pageSize = 20;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $countQuery = clone $this->query;
        $pagination = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $this->pageSize]);
        $this->query->offset($pagination->offset)->limit($pagination->limit);

        return $this->render("@humhub/modules/user/views/_listUsers", [
                    'title' => $this->title,
                    'users' => $this->query->all(),
                    'pagination' => $pagination
        ]);
    }

}