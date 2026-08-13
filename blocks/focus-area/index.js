(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/focus-area', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-focus-area alignfull' });

      return el(
        'div',
        blockProps,

        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: 'Налаштування блоку', initialOpen: true },
            el(TextControl, {
              label: 'URL для кнопки/картки',
              value: buttonUrl,
              onChange: (v) => setAttributes({ buttonUrl: v }),
            })
          )
        ),

        // Шапка блоку (Заголовок та Кнопка)
        el(
          'div',
          { className: 'uuwg-focus-area__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-focus-area__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            placeholder: 'Введіть заголовок...',
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-focus-area__cta',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            placeholder: 'Текст кнопки...',
            allowedFormats: [],
          })
        ),

        el(
          'div',
          { className: 'uuwg-focus-area__grids' },
          [1, 2, 3, 4].map(function (n) {
            const titleKey = `item${n}Title`;
            const textKey = `item${n}Text`;

            return el(
              'div',
              {
                className: 'uuwg-focus-area__two-cards'
              },
              el(
                'div',
                {
                  className: 'uuwg-focus-area__card',
                  key: n,
                },
                el('span', { className: 'uuwg-focus-area__card__number' }, `${n}/`),

                // Заголовок картки
                el(RichText, {
                  tagName: 'h3',
                  className: 'uuwg-focus-area__card__title',
                  value: attributes[titleKey],
                  onChange: (v) => setAttributes({ [titleKey]: v }),
                  placeholder: `Заголовок ${n}...`,
                  allowedFormats: [],
                }),

                // Опис картки
                el(RichText, {
                  tagName: 'div',
                  className: 'uuwg-focus-area__card__text',
                  value: attributes[textKey],
                  onChange: (v) => setAttributes({ [textKey]: v }),
                  placeholder: `Опис картки ${n}...`,
                  allowedFormats: ['core/bold', 'core/italic'],
                })
              ))
          })
        )
      );
    },

    save: function () {
      return null;
    },

  });

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
);