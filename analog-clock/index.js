( function ( blocks, element, data, blockEditor ) {
	var el = element.createElement,
		registerBlockType = blocks.registerBlockType,
		useSelect = data.useSelect,
		useBlockProps = blockEditor.useBlockProps;

	const { select, subscribe } = data;

	const closeListener = subscribe( () => {
		const isReady = select( 'core/editor' ).__unstableIsEditorReady();
		if ( ! isReady ) {
			// Editor not ready.
			return;
		}
		// Close the listener as soon as we know we are ready to avoid an infinite loop.
		closeListener();
		// Your code is placed after this comment, once the editor is ready.
		alert( 'is ready' );
	});

	registerBlockType( 'coolclock/analog-clock', {
		apiVersion: 2,
		title: 'Analog Clock',
		icon: 'clock',
		category: 'widgets',
		edit: function () {
			return el( 'figure', useBlockProps, el( 'canvas', { class: "CoolClock:coolskin:120:::showDate::::" } ) );
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.data,
	window.wp.blockEditor
);
