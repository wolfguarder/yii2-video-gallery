<?php

use wolfguard\video_gallery\migrations\Migration;

class m141226_163116_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%video_gallery}}', [
                'id' => $this->primaryKey(),
                'code' => $this->string()->notNull(),
                'name' => $this->string()->notNull(),
                'description' => $this->text(),
                'sort' => $this->integer()->defaultValue(500),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->createIndex('ix_video_gallery_name', '{{%video_gallery}}', 'name');
        $this->createIndex('ix_video_gallery_code', '{{%video_gallery}}', 'code', true);
        $this->createIndex('ix_video_gallery_sort', '{{%video_gallery}}', 'sort');

        /**
         * image_to_video_gallery:
         **/
        $this->createTable('{{%video_gallery_item}}', [
                'id' => $this->primaryKey(),
                'video_gallery_id' => $this->integer()->notNull(),
                'url' => $this->string(),
                'title' => $this->string(),
                'code' => $this->string()->notNull(),
                'description' => $this->text(),
                'sort' => $this->integer()->defaultValue(500),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->createIndex("ix_video_gallery_item_video_gallery_id", '{{%video_gallery_item}}', "video_gallery_id");
        $this->createIndex("ix_video_gallery_item_sort", '{{%video_gallery_item}}', "sort");
        $this->createIndex("ix_video_gallery_item_url", '{{%video_gallery_item}}', "url");
        $this->createIndex("ix_video_gallery_item_title", '{{%video_gallery_item}}', "title");
        $this->createIndex("ix_video_gallery_item_code", '{{%video_gallery_item}}', "code", true);

        $this->addForeignKey("fk_video_gallery_item_video_gallery_id",'{{%video_gallery_item}}', 'video_gallery_id','{{%video_gallery}}', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropForeignKey("fk_video_gallery_item_video_gallery_id",'{{%video_gallery_item}}');

        $this->dropTable('{{%video_gallery_item}}');
        $this->dropTable('{{%video_gallery}}');
    }
}
