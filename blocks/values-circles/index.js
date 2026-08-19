(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/values-circles', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, headerText } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-values-circles alignfull' });

      return el(
        'div',
        blockProps,

        el(InspectorControls, {},
          el(TextControl, {
            label: 'URL кнопки',
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        ),

        el(
          'div',
          { className: 'uuwg-values-circles__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-values-circles__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'p',
            className: 'uuwg-values-circles__header-text',
            value: headerText,
            onChange: (v) => setAttributes({ headerText: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-values-circles__cta wp-element-button',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          }),
        ),

        el(
          'div',
          { className: 'uuwg-values-circles__grids' },
          [1, 2, 3, 4, 5].map(function (n) {
            return el(
              'div',
              {
                className: 'uuwg-values-circles__card',
                key: n,
              },
              el(RichText, {
                tagName: 'h3',
                className: 'uuwg-values-circles__card__title',
                value: attributes[`item${n}Title`],
                onChange: (v) => setAttributes({ [`item${n}Title`]: v }),
                placeholder: `Заголовок ${n}...`,
                allowedFormats: [],
              }),
              el(RichText, {
                tagName: 'p',
                className: 'uuwg-values-circles__card__text',
                value: attributes[`item${n}Text`],
                onChange: (v) => setAttributes({ [`item${n}Text`]: v }),
                placeholder: `Опис картки ${n}...`,
                allowedFormats: [],
              })
            );
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