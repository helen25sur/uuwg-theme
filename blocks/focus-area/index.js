(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/focus-area', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-focus-area alignfull' });

      const itemPanels = [1, 2, 3, 4].map(function (n) {
        const titleKey = `item${n}Title`;

        return el(
          PanelBody,
          { title: `Картка ${n}`, initialOpen: n === 1, key: n },
          el(TextControl, {
            label: 'Заголовок',
            value: attributes[titleKey],
            onChange: (v) => setAttributes({ [titleKey]: v }),
          })
        );
      });

      return el(
        'div',
        blockProps,

        el(InspectorControls, {}, ...itemPanels),

        el(
          'div',
          { className: 'uuwg-focus-area__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-focus-area__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-focus-area__cta',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          })
        ),

        el(
          'div',
          { className: 'uuwg-focus-area__grids' },
          [1, 2, 3, 4].map(function (n) {
            const isActive = n === 1;
            return el(
              'div',
              {
                className: 'uuwg-focus-area__card',
                key: n,
              },
              el('span', { className: 'uuwg-focus-area__card__number' }, `${n}/`),
              el('h3', { className: 'uuwg-focus-area__card__title' }, attributes[`item${n}Title`])
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