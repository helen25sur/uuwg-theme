(function (blocks, blockEditor, components, element, i18n) {
  const { registerBlockType } = blocks;
  const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = blockEditor;
  const { PanelBody, TextControl, Button } = components;
  const el = element.createElement;
  const __ = i18n.__;

  registerBlockType('uuwg/hero', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const {
        title,
        subtitle,
        backgroundImageId,
        backgroundImageUrl,
        primaryButtonText,
        primaryButtonUrl,
        secondaryButtonText,
        secondaryButtonUrl,
      } = attributes;

      const blockProps = useBlockProps({
        style: backgroundImageUrl
          ? { backgroundImage: 'url(' + backgroundImageUrl + ')' }
          : {},
      });

      // Інспектор: усе, що НЕ прямий текст на банері (URL кнопок),
      // адмін редагує тут, а не через довільну зміну розмітки.
      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Кнопки', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Текст першої кнопки', 'uuwg'),
            value: primaryButtonText,
            onChange: function (value) {
              setAttributes({ primaryButtonText: value });
            },
          }),
          el(TextControl, {
            label: __('URL першої кнопки', 'uuwg'),
            value: primaryButtonUrl,
            onChange: function (value) {
              setAttributes({ primaryButtonUrl: value });
            },
          }),
          el(TextControl, {
            label: __('Текст другої кнопки', 'uuwg'),
            value: secondaryButtonText,
            onChange: function (value) {
              setAttributes({ secondaryButtonText: value });
            },
          }),
          el(TextControl, {
            label: __('URL другої кнопки', 'uuwg'),
            value: secondaryButtonUrl,
            onChange: function (value) {
              setAttributes({ secondaryButtonUrl: value });
            },
          })
        )
      );

      // Кнопка вибору фонового зображення — доступна тільки через
      // медіатеку, не можна "перетягнути" довільний елемент замість неї.
      const mediaControl = el(
        MediaUploadCheck,
        {},
        el(MediaUpload, {
          onSelect: function (media) {
            setAttributes({
              backgroundImageId: media.id,
              backgroundImageUrl: media.url,
            });
          },
          allowedTypes: ['image'],
          value: backgroundImageId,
          render: function (obj) {
            return el(
              Button,
              {
                onClick: obj.open,
                variant: 'secondary',
                className: 'uuwg-hero__bg-button',
              },
              backgroundImageUrl
                ? __('Змінити фонове зображення', 'uuwg')
                : __('Обрати фонове зображення', 'uuwg')
            );
          },
        })
      );

      return el(
        'div',
        blockProps,
        inspector,
        mediaControl,
        el(RichText, {
          tagName: 'h1',
          className: 'uuwg-hero__title',
          value: title,
          onChange: function (value) {
            setAttributes({ title: value });
          },
          placeholder: __('Заголовок банера…', 'uuwg'),
          allowedFormats: [], // без inline-форматування — тільки текст, щоб не ламати типографіку
        }),
        el(RichText, {
          tagName: 'p',
          className: 'uuwg-hero__subtitle',
          value: subtitle,
          onChange: function (value) {
            setAttributes({ subtitle: value });
          },
          placeholder: __('Підзаголовок…', 'uuwg'),
        }),
        el(
          'div',
          { className: 'uuwg-hero__buttons' },
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-hero__button uuwg-hero__button--primary wp-element-button',
            value: primaryButtonText,
            onChange: function (value) {
              setAttributes({ primaryButtonText: value });
            },
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-hero__button uuwg-hero__button--secondary',
            value: secondaryButtonText,
            onChange: function (value) {
              setAttributes({ secondaryButtonText: value });
            },
            allowedFormats: [],
          })
        )
      );
    },

    save: function () {

      return null;

    },
    // === ДОДАЄМО МАСИВ ЗАСПАРЕНИХ ВЕРСІЙ ===
    deprecated: [
      {
        // Описуємо стару версію save(), яка згенерувала HTML, що зараз лежить у БД
        save: function (props) {
          const { attributes } = props;
          const {
            title,
            subtitle,
            primaryButtonText,
            secondaryButtonText,
          } = attributes;

          const blockProps = blockEditor.useBlockProps.save({
            className: 'uuwg-hero',
          });

          // Відтворюємо структуру елементів, яка зберігалася в post_content раніше
          return el(
            'div',
            blockProps,
            el(RichText.Content, {
              tagName: 'h1',
              className: 'uuwg-hero__title',
              value: title,
            }),
            el(RichText.Content, {
              tagName: 'p',
              className: 'uuwg-hero__subtitle',
              value: subtitle,
            }),
            el(
              'div',
              { className: 'uuwg-hero__buttons' },
              el('span', { className: 'uuwg-hero__button' }, primaryButtonText),
              el('span', { className: 'uuwg-hero__button' }, secondaryButtonText)
            )
          );
        },
      },
    ],
  });
})(
  window.wp.blocks,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.element,
  window.wp.i18n
);
