import React, { useState, useEffect, useRef, useMemo } from "react";
import botchat from "../../Assets/Images/botchat.png";
import MessangerInput from "./MessangerInput";

function ChatBox() {
  const [messages, setMessages] = useState([]);
  const [waitingForAnswer, setWaitingForAnswer] = useState(true);
  const [options, setOptions] = useState([]);
  const [isOpen, setIsOpen] = useState(true);
  const messagesEndRef = useRef(null);

  const optionsList = useMemo(
    () => [
      "Xin chào!!! Tôi muốn nộp hồ sơ tuyển sinh",
      "Địa chỉ liên hệ của trường?",
      "Trường còn nhận hồ sơ không?",
      "Tôi muốn ứng tuyển nhân viên tại trường!",
      "Học phí của trường như thế nào?",
      "Các ngành đào tạo của trường?",
      "Thời gian học tại trường?",
      "Chính sách học bổng của trường?",
      "Cơ sở vật chất của trường?",
      "Chương trình thực tập tại trường?",
      "Công nghệ thông tin có chuyên ngành nào?",
      "Thiết kế đồ họa có chuyên ngành nào?",
    ],
    []
  );

  useEffect(() => {
    if (messages.length === 0) {
      const questionMessage = "Xin chào!!! Bạn cần hỗ trợ điều gì từ tôi?";
      setMessages([`SyseduBot: ${questionMessage}`]);
    }
    setOptions(optionsList);
    setWaitingForAnswer(true);
  }, [messages.length, optionsList]);

  const handleBotReply = (userMessage) => {
    const responses = {
      "xin chào!!! tôi muốn nộp hồ sơ tuyển sinh":
        "Chào bạn! Để nộp hồ sơ tuyển sinh, vui lòng truy cập trang website tuyển sinh hoặc đến văn phòng tuyển sinh Sysedu để được tư vấn hỗ trợ!",
      "địa chỉ liên hệ của trường?":
        "Trường có địa chỉ tại: Toà nhà F, Phường Trường Thạnh, Quận Ninh Kiều, TP. Cần Thơ. Bạn cũng có thể liên hệ hotline 0345456544 hoặc 0345456545 để được hỗ trợ thêm.",
      "trường còn nhận hồ sơ không?":
        "Chúng tôi đang mở tuyển sinh! Vui lòng kiểm tra thêm thông tin trên website của chúng tôi để biết chi tiết.",
      "tôi muốn ứng tuyển nhân viên tại trường!":
        "Hiện tại trường không còn nhận tuyển dụng nữa. Xin lỗi và cảm ơn bạn đã quan tâm!",
      "học phí của trường như thế nào?":
        "Học phí của trường dao động từ 25-30 triệu/năm tùy theo ngành học. Trường có nhiều chính sách hỗ trợ học phí và học bổng cho sinh viên.",
      "các ngành đào tạo của trường?":
        "Hiện tại trường đang đào tạo các ngành: Công nghệ thông tin, Thiết kế đồ họa, Quản trị kinh doanh, Marketing, Kế toán, và nhiều ngành hot khác.",
      "thời gian học tại trường?":
        "Thời gian đào tạo từ 2-3 năm tùy theo ngành học. Lịch học linh hoạt với cả ca sáng và ca chiều.",
      "chính sách học bổng của trường?":
        "Trường có nhiều chương trình học bổng hấp dẫn như: Học bổng đầu vào, học bổng khuyến khích học tập, học bổng tài năng với mức hỗ trợ lên đến 100% học phí.",
      "cơ sở vật chất của trường?":
        "Trường có cơ sở vật chất hiện đại với phòng học máy lạnh, thư viện, phòng thực hành, căng tin, khu thể thao và nhiều tiện ích khác.",
      "chương trình thực tập tại trường?":
        "Sinh viên được tham gia thực tập tại các doanh nghiệp đối tác của trường từ năm 2. Trường có mạng lưới hơn 100 doanh nghiệp liên kết.",
      "công nghệ thông tin có chuyên ngành nào?":
        "Công nghệ thông tin (CNTT) là một lĩnh vực rộng lớn, hiện tại trường đang đào tạo các chuyên ngành cơ bản như: Lập trình Website, Phát triển phần mềm,...",
      "thiết kế đồ họa có chuyên ngành nào?":
        "Thiết kế đồ họa (Graphic Design) là một lĩnh vực sáng tạo hiện dang được trường đào tạo gồm có: Thiết kế thương hiệu, Thiết kế giao diện người dùng, Thiết kế in ấn,...",
    };

    const normalizedMessage = userMessage.toLowerCase().trim();
    const reply =
      responses[normalizedMessage] ||
      "Tôi không hiểu. Bạn có thể hỏi lại không?";

    setTimeout(() => {
      setMessages((prev) => [...prev, `SyseduBot: ${reply}`]);
      setWaitingForAnswer(false);
    }, 1500);
  };

  const handleSendMessage = (newMessage) => {
    if (!newMessage.trim()) return;
    setMessages((prev) => [...prev, `Bạn: ${newMessage}`]);

    if (waitingForAnswer) {
      if (optionsList.includes(newMessage)) {
        handleBotReply(newMessage);
      } else {
        setMessages((prev) => [
          ...prev,
          `SyseduBot: Chào bạn!!! Bạn vui lòng chọn những gợi ý bên dưới để biết thêm chi tiết`,
        ]);
      }
    } else {
      handleBotReply(newMessage);
    }
  };

  useEffect(() => {
    if (messagesEndRef.current) {
      messagesEndRef.current.scrollIntoView({ behavior: "smooth" });
    }
  }, [messages]);

  return (
    <div className="fixed bottom-10 right-10 z-50">
      {!isOpen && (
        <div onClick={() => setIsOpen(true)}>
          <img src={botchat} alt="botchat" className="w-25 animate-bounce" />
        </div>
      )}

      {isOpen && (
        <div className="w-full max-w-md mx-auto mt-10 flex flex-col h-[500px] bg-white rounded-lg shadow-md">
          <div className="bg-blue-600 text-white text-center py-3 font-bold rounded-t-lg relative">
            Hỏi đáp nhanh Sysedu
            <button
              onClick={() => setIsOpen(false)}
              className="absolute top-2 right-5 text-white text-xl"
            >
              &times;
            </button>
          </div>

          <div className="flex flex-col space-y-4 mt-2 px-6 py-2 overflow-y-auto flex-grow max-h-[400px]">
            {messages.map((message, index) => {
              const isBotMessage = message.startsWith("SyseduBot");
              return (
                <div
                  key={index}
                  className={`flex ${
                    isBotMessage ? "justify-start" : "justify-end"
                  } items-start`}
                >
                  <div
                    className={`px-4 py-2 rounded-lg ${
                      isBotMessage ? "bg-green-600" : "bg-blue-600"
                    } max-w-[80%]`}
                  >
                    <p className="text-white">{message}</p>
                  </div>
                </div>
              );
            })}
            <div ref={messagesEndRef} />
          </div>
          {/* gợi ý */}
          {waitingForAnswer && (
            <div className="px-4 py-2 bg-gray-100 rounded-lg shadow">
              <p className="text-gray-600 text-sm mb-2 font-medium">
                Gợi ý câu hỏi:
              </p>
              <div className="flex flex-wrap gap-2 pb-1 max-h-[80px] overflow-y-auto">
                {options.map((option, index) => (
                  <div
                    key={index}
                    className="px-3 py-1.5 bg-white border border-blue-200 text-blue-600 rounded-full cursor-pointer hover:bg-blue-50 transition-colors duration-200 text-sm font-medium shadow-sm flex items-center gap-1.5 whitespace-nowrap"
                    onClick={() => handleSendMessage(option)}
                  >
                    <i className="fas fa-lightbulb text-yellow-400 text-xs"></i>
                    {option}
                  </div>
                ))}
              </div>
            </div>
          )}

          <MessangerInput onSendMessage={handleSendMessage} />
        </div>
      )}
    </div>
  );
}

export default ChatBox;
