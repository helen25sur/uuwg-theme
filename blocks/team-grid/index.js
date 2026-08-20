(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextControl, Spinner } = components;
  const { __, sprintf } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/team-grid', {
    edit: function (props) {
      const { attributes, setAttributes } = props;

      const { heading, buttonText, buttonUrl } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-team-grid alignfull' });

      const { team, totalPages } = useSelect(
        function (select) {
          const query = { per_page: 100, _embed: true, order: 'asc', orderby: 'date' };
          return {
            team: select('core').getEntityRecords('postType', 'team_member', query),
            totalPages: select('core').getEntityRecordsTotalPages('postType', 'team_member', query) || 1,
          };
        },
        []
      );

      const inspector = el(
        InspectorControls,
        {},
        el(TextControl, {
          label: __('Button URL', 'uuwg'),
          value: buttonUrl,
          onChange: (v) => setAttributes({ buttonUrl: v }),
        })
      );

      let teamGrid;
      if (team === null) {
        teamGrid = el('div', { className: 'uuwg-team-grid__loading' }, el(Spinner), ' ', __('Loading...', 'uuwg'));
      } else if (team.length === 0) {
        teamGrid = el('p', { className: 'uuwg-team-grid__empty' }, __('Not Found.', 'uuwg'));
      } else {
        teamGrid = team.map(function (member) {
          const media = member._embedded && member._embedded['wp:featuredmedia'] && member._embedded['wp:featuredmedia'][0];
          const imageUrl = media ? media.source_url : null;

          return el(
            'div', { className: 'uuwg-team-grid__card', key: member.id },
            imageUrl && el('img', { src: imageUrl, alt: member.title.rendered, className: 'uuwg-team-grid__card-img' }),
            el('div', { className: 'uuwg-team-grid__card__content' },
              el('h3', { className: 'uuwg-team-grid__card__title', dangerouslySetInnerHTML: { __html: member.title.rendered } }),
              el('span', {className: 'uuwg-team-grid__card__tip',}, __('Other values, position, period and social links you can see on the site and you can edit into every team member separately', 'uuwg'))
            )
          );
        });
      }

      return el(
        'div',
        blockProps,
        inspector,
        el(
          'div', { className: 'uuwg-team-grid__content' },
          el('div', { className: 'uuwg-team-grid__header' },
            el(RichText, { tagName: 'h2', className: 'uuwg-team-grid__heading', value: heading, onChange: (v) => setAttributes({ heading: v }), placeholder: __('Title...', 'uuwg') }),
            el(RichText, { tagName: 'span', className: 'uuwg-team-grid__cta uuwg-btn', value: buttonText, onChange: (v) => setAttributes({ buttonText: v }), placeholder: __('Button text...', 'uuwg') })
          ),
          el('div', { className: 'uuwg-team-grid__grids' }, teamGrid)
        )
      );
    },
    save: function () { return null; },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);