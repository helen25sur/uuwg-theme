(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/get-involved', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, item1Title, item1Text, item1ButtonText, item1ButtonUrl, item2Title, item2Text, item2ButtonText, item2ButtonUrl } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-get-involved alignfull' });

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
              label: 'URL для кнопки 1',
              value: item1ButtonUrl,
              onChange: (v) => setAttributes({ item1ButtonUrl: v }),
            }),
            el(TextControl, {
              label: 'URL для кнопки 2',
              value: item2ButtonUrl,
              onChange: (v) => setAttributes({ item2ButtonUrl: v }),
            })
          )
        ),

        el(
          'div',
          { className: 'uuwg-get-involved__content' },
          el(
            'div',
            { className: 'uuwg-get-involved__header' },
            el(RichText, {
              tagName: 'h2',
              className: 'uuwg-get-involved__heading',
              value: heading,
              onChange: (v) => setAttributes({ heading: v }),
              placeholder: 'Введіть заголовок...',
              allowedFormats: [],
            })
          ),

          el(
            'div',
            { className: 'uuwg-get-involved__grids' },
            [1, 2].map(function (n) {
              const titleKey = `item${n}Title`;
              const textKey = `item${n}Text`;
              const buttonKey = `item${n}ButtonText`;

              return el(
                'div',
                {
                  className: 'uuwg-get-involved__card',
                  key: n,
                },

                // Заголовок картки
                el(RichText, {
                  tagName: 'h3',
                  className: 'uuwg-get-involved__card__title',
                  value: attributes[titleKey],
                  onChange: (v) => setAttributes({ [titleKey]: v }),
                  placeholder: `Заголовок ${n}...`,
                  allowedFormats: [],
                }),

                // Опис картки
                el(RichText, {
                  tagName: 'div',
                  className: 'uuwg-get-involved__card__text',
                  value: attributes[textKey],
                  onChange: (v) => setAttributes({ [textKey]: v }),
                  placeholder: `Опис картки ${n}...`,
                  allowedFormats: ['core/bold', 'core/italic'],
                }),
                el(RichText, {
                  tagName: 'span',
                  className: 'uuwg-get-involved__card__cta wp-element-button',
                  value: attributes[buttonKey],
                  onChange: (v) => setAttributes({ [buttonKey]: v }),
                  placeholder: `Button text ${n}...`,
                  allowedFormats: [],
                }),
              );
            })
          ))
      )

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