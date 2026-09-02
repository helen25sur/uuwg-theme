(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/impact-glance', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, headerText } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-impact-glance alignfull' });

      const items = window.uuwgImpact?.items ?? [];

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
          { className: 'uuwg-impact-glance__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-impact-glance__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'p',
            className: 'uuwg-impact-glance__header-text',
            value: headerText,
            onChange: (v) => setAttributes({ headerText: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-impact-glance__cta wp-element-button',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          }),
        ),

        el(
          'div',
          { className: 'uuwg-impact-glance__editor-note' },
          'Impact values can be edited in Site Setting.'
        ),

        el(
          'div',
          { className: 'uuwg-impact-glance__grids' },

          items.map(function (item, index) {
            return el(
              'div',
              {
                className: 'uuwg-impact-glance__card',
                key: index,
              },

              el(
                'h3',
                {
                  className: 'uuwg-impact-glance__card__title',
                },
                `${item.number}+`
              ),

              el(
                'p',
                {
                  className: 'uuwg-impact-glance__card__text',
                },
                item.label
              )
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