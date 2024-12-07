
<style>
  /* Slide-in animation */
  @keyframes slide-in {
      0% {
          transform: translateX(-100%);
      }
      100% {
          transform: translateX(0); 
      }
  }

  /* animation  */
  @keyframes slide-out {
      0% {
          transform: translateX(0); 
      }
      100% {
          transform: translateX(-120%); /
      }
  }

  /* Apply the animate animation */
  .animate {
      animation: slide-in 0.5s ease-out forwards,
       slide-out 0.5s ease-out 5s forwards;
  }
</style>
