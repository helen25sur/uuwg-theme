(function (blocks, blockEditor, components, element, i18n) {
  const { registerBlockType } = blocks;
  const { useBlockProps, RichText, InspectorControls } = blockEditor;
  const { PanelBody, TextControl } = components;
  const el = element.createElement;
  const __ = i18n.__;

  registerBlockType('uuwg/hero', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const {
        title,
        subtitle,
        yellowButtonText,
        yellowButtonUrl,
        secondaryButtonText,
        secondaryButtonUrl,
      } = attributes;

      const blockProps = useBlockProps({
        className: 'uuwg-hero',
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
            value: yellowButtonText,
            onChange: function (value) {
              setAttributes({ yellowButtonText: value });
            },
          }),
          el(TextControl, {
            label: __('URL першої кнопки', 'uuwg'),
            value: yellowButtonUrl,
            onChange: function (value) {
              setAttributes({ yellowButtonUrl: value });
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

      return el(
        'section',
        blockProps,
        inspector,
        el(RichText, {
          tagName: 'h1',
          className: 'uuwg-hero__title',
          value: title,
          onChange: function (value) {
            setAttributes({ title: value });
          },
          placeholder: __('Заголовок банера…', 'uuwg'),
          allowedFormats: [],
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
            value: yellowButtonText,
            onChange: function (value) {
              setAttributes({ yellowButtonText: value });
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

    deprecated: [
      {
        save: function (props) {
          const { attributes } = props;
          const {
            title,
            subtitle,
            yellowButtonText,
            secondaryButtonText,
          } = attributes;

          const blockProps = blockEditor.useBlockProps.save({
            className: 'uuwg-hero',
          });

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
              el('span', { className: 'uuwg-hero__button' }, yellowButtonText),
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