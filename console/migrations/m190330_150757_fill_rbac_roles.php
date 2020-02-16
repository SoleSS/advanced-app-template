<?php

use yii\db\Migration;

/**
 * Class m190330_150757_fill_rbac_roles
 */
class m190330_150757_fill_rbac_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('auth_item', ['name', 'type', 'created_at', 'updated_at', ], [
            ['Administrator', 1, time(), time(), ],
            ['RegisteredUser', 1, time(), time(), ],
            ['GlobalUserAdmin', 2, time(), time(), ],
            ['FileManagerAccess', 2, time(), time(), ],
            ['GlobalReadAccess', 2, time(), time(), ],
            ['GlobalWriteAccess', 2, time(), time(), ],
            ['OwnWriteAccess', 2, time(), time(), ],
            //['CmsArticleAdmin', 2, time(), time(), ],
            //['CmsCategoryAdmin', 2, time(), time(), ],
            //['CmsTagAdmin', 2, time(), time(), ],
        ]);

        $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['Administrator', 'GlobalUserAdmin'],
            ['Administrator', 'FileManagerAccess'],
            ['Administrator', 'GlobalReadAccess'],
            ['Administrator', 'GlobalWriteAccess'],
            ['Administrator', 'OwnWriteAccess'],
            //['Administrator', 'CmsArticleAdmin'],
            //['Administrator', 'CmsCategoryAdmin'],
            //['Administrator', 'CmsTagAdmin'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('auth_item', ['OR',
            ['name' => 'Administrator'],
            ['name' => 'RegisteredUser'],
            ['name' => 'GlobalUserAdmin'],
            ['name' => 'FileManagerAccess'],
            ['name' => 'GlobalReadAccess'],
            ['name' => 'GlobalWriteAccess'],
            ['name' => 'OwnWriteAccess'],
            ['name' => 'CmsArticleAdmin'],
            ['name' => 'CmsCategoryAdmin'],
            ['name' => 'CmsTagAdmin'],
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190330_150757_fill_rbac_roles cannot be reverted.\n";

        return false;
    }
    */
}
