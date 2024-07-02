import { useContext, Suspense, lazy } from 'react';

let Component = null;
const Redactor = ( props ) => {
	if ( Component === null ) {
		Component = lazy( () =>
			import( `../../../${ props.blockName }/EditBlock/Redactor/Redactor` )
		);
	}

	return (
		<div className="blocks-redactor">
			<Suspense fallback={ <div>Loading...</div> }>
				<Component { ...props } />
			</Suspense>
		</div>
	);
}

export default Redactor;
