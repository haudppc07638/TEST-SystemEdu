import React, { useState } from "react";

function MessangerInput({ onSendMessage }) {
    const [inputValue, setInputValue] = useState("");

    const handleInputChange = (e) => {
        setInputValue(e.target.value);
    };

    const handleSendClick = () => {
        if (inputValue.trim() !== "") {
            onSendMessage(inputValue);
            setInputValue("");
        }
    };

    const handleKeyDown = (e) => {
        if (e.key === "Enter") {
            handleSendClick();
        }
    };

    return (
        <div className="flex p-4 bg-white">
            <input
                type="text"
                value={inputValue}
                onChange={handleInputChange}
                onKeyDown={handleKeyDown}
                placeholder="Nhập câu hỏi của bạn..."
                className="flex-1 px-3 py-2 border border-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <button
                onClick={handleSendClick}
                className="ml-2 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600"
            >
                Gửi
            </button>
        </div>
    );
}

export default MessangerInput;
