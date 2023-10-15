import React from "react";

const ErrorC = ({ children, ...props }) => {
    return <small className="text-danger">{children}</small>;
};

export default ErrorC;
