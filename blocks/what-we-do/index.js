(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText, TextControl } = blockEditor;
  const { PanelBody, TextareaControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/what-we-do', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-what-we-do' });

      const itemPanels = [1, 2, 3, 4, 5].map(function (n) {
        const titleKey = `item${n}Title`;
        const textKey = `item${n}Text`;
        const linkKey = `item${n}LinkUrl`;

        return el(
          PanelBody,
          { title: `Картка ${n}`, initialOpen: n === 1, key: n },
          el(TextControl, {
            label: 'Заголовок',
            value: attributes[titleKey],
            onChange: (v) => setAttributes({ [titleKey]: v }),
          }),
          el(TextareaControl, {
            label: 'Текст (тільки для картки, що відкрита за замовчуванням)',
            value: attributes[textKey],
            onChange: (v) => setAttributes({ [textKey]: v }),
          }),
          el(TextControl, {
            label: 'URL кнопки-стрілки',
            value: attributes[linkKey],
            onChange: (v) => setAttributes({ [linkKey]: v }),
          })
        );
      });

      return el(
        'div',
        blockProps,

        el(InspectorControls, {}, ...itemPanels),

        el(
          'div',
          { className: 'uuwg-what-we-do__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-what-we-do__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'span',
            className: 'uuwg-what-we-do__cta',
            value: buttonText,
            onChange: (v) => setAttributes({ buttonText: v }),
            allowedFormats: [],
          })
        ),

        el(
          'div',
          { className: 'uuwg-what-we-do__cards' },
          [1, 2, 3, 4, 5].map(function (n) {
            const isActive = n === 1;
            return el(
              'div',
              {
                className: 'uuwg-what-we-do__card' + (isActive ? ' is-active' : ''),
                key: n,
              },
              el('h3', { className: 'uuwg-what-we-do__card-title' }, attributes[`item${n}Title`]),
              isActive &&
              el('p', { className: 'uuwg-what-we-do__card-text' }, attributes[`item${n}Text`]),
              el('span', { className: 'uuwg-what-we-do__card-toggle' }, '→')
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