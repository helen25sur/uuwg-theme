(function (blocks, element, blockEditor, components) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextareaControl, TextControl } = components;
  const el = element.createElement;

  registerBlockType('uuwg/documents-grid', {

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-documents-grid' });

      return el(
        'div',
        blockProps,

        el(
          'div',
          { className: 'uuwg-documents-grid__header' },
          el(RichText, {
            tagName: 'h2',
            className: 'uuwg-documents-grid__heading',
            value: heading,
            onChange: (v) => setAttributes({ heading: v }),
            allowedFormats: [],
          })
        ),

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