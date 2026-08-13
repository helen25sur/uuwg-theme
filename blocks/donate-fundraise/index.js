(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/donate-fundraise', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, headerText } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-donate-fundraise alignfull' });

      const itemPanels = [1, 2, 3, 4].map(function (n) {
        const textKey = `item${n}Text`;

        return el(
          PanelBody,
          { text: `Елемент ${n}`, initialOpen: n === 1, key: n },
          el(TextControl, {
            label: 'Text',
            value: attributes[textKey],
            onChange: (v) => setAttributes({ [textKey]: v }),
          })
        );
      });

      return el(
        'div',
        blockProps,

        el(InspectorControls, {},
          el(
            PanelBody,
            { title: 'Налаштування блоку', initialOpen: true },
            el(TextControl, {
              label: 'URL для кнопки',
              value: buttonUrl,
              onChange: (v) => setAttributes({ buttonUrl: v }),
            })
          )
        ),

        el(
          'div',
          { className: 'uuwg-donate-fundraise__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-donate-fundraise__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          }),
          el(RichText, {
            tagName: 'div',
            className: 'uuwg-donate-fundraise__header__text',
            value: headerText,
            onChange: (v) => setAttributes({ headerText: v }),
          })
        ),

        el(
          'div',
          { className: 'uuwg-donate-fundraise__grids' },
          [1, 2, 3, 4].map(function (n) {
            const isActive = n === 1;
            return el(
              'div',
              {
                className: 'uuwg-donate-fundraise__card',
                key: n,
              },
              el(
                RichText, {
                tagName: 'p',
                className: 'uuwg-donate-fundraise__card__text',
                value: attributes[`item${n}Text`],
                onChange: (v) => setAttributes({ [`item${n}Text`]: v }),
              }
              )
            );
          })
        ),
        el(RichText, {
          tagName: 'span',
          className: 'uuwg-donate-fundraise__cta',
          value: buttonText,
          onChange: (v) => setAttributes({ buttonText: v }),
          allowedFormats: [],
        })
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