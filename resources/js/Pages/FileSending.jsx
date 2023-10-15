import React, { useState } from "react";
import { useFormik, Formik, Form, Field, ErrorMessage } from "formik";
import ErrorC from "@/Components/Form/ErrorC";
import { router } from "@inertiajs/react";
import { Alert } from "react-bootstrap";

const FileSending = () => {
    const InValues = {
        profile: null,
    };

    const [messageFeedback, setMessage] = useState("");
    const SendSubmit = (values, pr) => {
        router.visit("/send-s3-profile", {
            method: "post",
            preserveState: true,
            data: values,
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onSuccess: ({ props }) => {
                const { flash } = props;
                const { success } = flash;
                setMessage(success);
            },
            onError: (eror) => {
                try {
                    for (var er in eror) {
                        pr.setFieldError(er, eror[er]);
                    }
                } catch (error) {
                    console.log("ERROR FOUND");
                }
            },
            onFinish: () => {
                pr.setSubmitting(false);
            },
        });
    };
    return (
        <section className="container">
            <h6 className="text-light">s3 Bucket File storage</h6>

            {messageFeedback && <Alert dismissible variant="success">
                <strong>{messageFeedback}</strong>
            </Alert>}


            <section className="col-lg-5 col-sm-6 mt-2">
                <Formik initialValues={InValues} onSubmit={SendSubmit}>
                    {(formik) => {
                        return (
                            <Form className="vstack gap-3">
                                <section>
                                    <section className="form-floating">
                                        <input
                                            onChange={(e) => {
                                                formik.setFieldValue(
                                                    "profile",
                                                    e.target.files[0]
                                                );
                                            }}
                                            type="file"
                                            className="form-control"
                                        />
                                        <label className="form-label">
                                            Choose File
                                        </label>
                                    </section>

                                    <ErrorMessage
                                        name="profile"
                                        component={ErrorC}
                                    />
                                </section>

                                <section>
                                    <button
                                        disabled={formik.isSubmitting}
                                        type="submit"
                                        className="btn btn-outline-success"
                                    >
                                        Send
                                    </button>
                                </section>
                            </Form>
                        );
                    }}
                </Formik>
            </section>
        </section>
    );
};

export default FileSending;
