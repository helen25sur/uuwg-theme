(function (blocks, element, blockEditor) {
  const { registerBlockType } = blocks;

  const { useBlockProps } = blockEditor;

  const el = element.createElement;

  registerBlockType('uuwg/join-us-btn', {
    apiVersion: 3,
    edit: function () {
      const blockProps = useBlockProps({
        className: 'chat_button__container',
      });

      return el(
        'div',
        blockProps,
        el(
          'a',
          {
            className: 'chat_button__link',
            'aria-label': 'Join Us: Telegram Channel',
          },
          'Join our chat'
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
  window.wp.blockEditor
);