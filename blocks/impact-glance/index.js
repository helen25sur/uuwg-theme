(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/impact-glance', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, headerText } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-impact-glance' });

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
            className: 'uuwg-impact-glance__cta',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          }),
        ),

        el(
          'div',
          { className: 'uuwg-impact-glance__grids' },
          [1, 2, 3, 4].map(function (n) {
            const isActive = n === 1;
            return el(
              'div',
              {
                className: 'uuwg-impact-glance__card',
                key: n,
              },
              el('h3', { className: 'uuwg-impact-glance__card__title' }, attributes[`item${n}Title`]),
              el('p', { className: 'uuwg-impact-glance__card__text' }, attributes[`item${n}Text`]),
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