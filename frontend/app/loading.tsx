import React from 'react';

const Loader = () => {
    return (
        <svg width="100%" height="100%" viewBox="0 0 1200 400" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="0" width="100%" height="20" fill="#E0E0E0" />
            {Array.from({ length: 10 }).map((_, index) => (
                <g key={index} transform={`translate(0, ${(index + 1) * 40})`}>
                    <rect x="0" y="0" width="30%" height="20" fill="#E0E0E0" />
                    <rect x="35%" y="0" width="30%" height="20" fill="#E0E0E0" />
                    <rect x="70%" y="0" width="30%" height="20" fill="#E0E0E0" />
                </g>
            ))}
        </svg>
    );
};

export default Loader;