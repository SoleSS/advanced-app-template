<?php

namespace common\models;

/**
 * This is the model class for table "cms_article".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $title_lng1 Заголовок (язык #1)
 * @property string $title_lng2 Заголовок (язык #2)
 * @property int $type_id Тип документа
 * @property string $subtitle Подзаголовок
 * @property string $subtitle_lng1 Подзаголовок (язык #1)
 * @property string $subtitle_lng2 Подзаголовок (язык #2)
 * @property string $image Изображение
 * @property int $image_width Ширина изображения
 * @property int $image_height Высота изображения
 * @property int $show_image Отображать изображение?
 * @property string $intro Вводный текст
 * @property string $intro_lng1 Вводный текст (язык #1)
 * @property string $intro_lng2 Вводный текст (язык #2)
 * @property string $full Полный текст
 * @property string $full_lng1 Полный текст (язык #1)
 * @property string $full_lng2 Полный текст (язык #2)
 * @property string $amp_full Полный текст (AMP версия)
 * @property string $amp_full_lng1 Полный текст (AMP версия) (язык #1)
 * @property string $amp_full_lng2 Полный текст (AMP версия) (язык #2)
 * @property int $published Опубликован?
 * @property string $publish_up Дата начала публикации
 * @property string $publish_down Дата окончания публикации
 * @property int $user_id id Автора
 * @property string $user_alias Алиас автора
 * @property string $meta_keywords Meta keywords
 * @property string $meta_description Meta description
 * @property int $hits Кол-во просмотров
 * @property array $medias Медиа контент
 * @property array $gallery Галерея
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 *
 * @property User $user
 * @property CmsCategory[] $cmsCategories
 * @property CmsTag[] $relatedTags
 * @property CmsTag[] $tags
 */
class CmsArticle extends base\CmsArticle
{
    public function hasGallery() {
        if (empty($this->gallery)) return false;

        $paths = \yii\helpers\ArrayHelper::getColumn($this->gallery, 'path');
        if (!empty(implode('', $paths))) return true;

        return false;
    }

    public function hasYTVideos() {
        $medias = array_unique(\yii\helpers\ArrayHelper::getColumn($this->medias, 'type'));
        if (in_array('youtube-video', $medias)) return true;

        return false;
    }
  
    public function getIntroImage() {
        $image = null;

        if ($this->show_image && !empty($this->image)) $image = $this->image;

        return $image;
    }
}
